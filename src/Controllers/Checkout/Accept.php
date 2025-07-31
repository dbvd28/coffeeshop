<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Administrator\Orders;
use Utilities\Security;
use Utilities\Site;
use Dao\Administrator\Orders as ODAO;
const LIST_URL = "index.php?page=Checkout-Checkout";
class Accept extends PublicController
{
    private array $viewData;
    public function __construct()
    {
        $this->viewdata = [
            "pedidoId" => "",
            "correo"=>"",
            "estado"=>"",
            "nombre" => "",
            "fecha" => "",
            "total" => "",
            "productos" => []
        ];
    }
    public function run(): void
    {

        $token = $_GET["token"] ?: "";
        $session_token = $_SESSION["orderid"] ?: "";
        if ($token !== "" && $token == $session_token) {
            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $result = $PayPalRestApi->captureOrder($session_token);
            $archivo = json_encode($result);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
            $resultArray = json_decode(json_encode($result), true);
            $amount = $resultArray["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"];
            $orderId = Orders::addOrder(Security::getUserId(), floatval($amount), $archivo);
            Orders::transferTempCartToOrder(Security::getUserId(), $orderId);
            $this->viewData["pedidoId"] = $orderId;
            $this->getDataFromDB();
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }
        Site::addLink("public/css/accept.css");
        \Views\Renderer::render("paypal/accept", $this->viewData);

    }
    private function getDataFromDB()
    {
        $tmpPedido = ODAO::getOrdersById(
            $this->viewData["pedidoId"]
        );
        if ($tmpPedido && count($tmpPedido) > 0) {
            $this->viewData["fecha"] = $tmpPedido["fchpedido"];
            $this->viewData["estado"] = $tmpPedido["estado"];
            $this->viewData["nombre"] = $tmpPedido["username"];
            $this->viewData["correo"] = $tmpPedido["useremail"];
            $this->viewData["total"] = $tmpPedido["total"];
        } else {
            $this->throwError(
                "Something went wrong, try again.",
                "Record for id " . $this->viewData["id"] . " not found."
            );
        }
        $tmpProductos = ODAO::getProductsOrders(
            $this->viewData["pedidoId"]
        );
        if (is_array($tmpProductos)) {
            foreach ($tmpProductos as &$producto) {
                $cantidad = (float) $producto["cantidad"];
                $precio = (float) $producto["precio_unitario"];
                $producto["subtotal"] = number_format($cantidad * $precio, 2, '.', '');
            }
            $this->viewData["productos"] = $tmpProductos;
        } else {
            $this->throwError(
                "Something went wrong, try again.",
                "Products not found for this order."
            );
        }
    }
    private function throwError(string $message, string $logMessage = "")
    {
        if (!empty($logMessage)) {
            error_log(sprintf("%s - %s", $this->name, $this->$logMessage));
        }
        Site::redirectToWithMsg(LIST_URL, $message);
    }
}
