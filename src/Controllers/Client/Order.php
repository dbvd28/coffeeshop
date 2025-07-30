<?php

namespace Controllers\Client;

use Controllers\PrivateController;
use Dao\Client\Orders as ODAO;
use Views\Renderer;

use Utilities\Site;
use Utilities\Validators;

const LIST_URL = "index.php?page=Client-Orders";

class Order extends PrivateController
{
    private array $viewData;
    private array $status;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "mode" => "DSP",
            "id" => 0,
            "fecha" => "",
            "estado" => "",
            "nombre" => "",
            "correo" => "",
            "total" => "",
            "productos" => [],
            "readonly" => "readonly",
            "errors" => [],
            "cancelLabel" => "Back",
            "showConfirm" => false,
        ];
        $this->status = ["ENV", "PAG", "PEND"];
    }

    public function run(): void
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            Site::redirectToWithMsg("index.php?page=Client-Orders", "Invalid request.");
        }
        $this->viewData["id"] = intval($_GET["id"]);
        $userId = $_SESSION["usercod"] ?? 0;

        $pedido = ODAO::getOrdersById($this->viewData["id"]);

        // Validar que el pedido pertenece al usuario
        if (!$pedido || $pedido["usercod"] != $userId) {
            Site::redirectToWithMsg("index.php?page=Client-Orders", "Access denied.");
        }

        $this->viewData["fecha"] = $pedido["fchpedido"];
        $this->viewData["estado"] = $pedido["estado"];
        $this->viewData["nombre"] = $pedido["username"];
        $this->viewData["correo"] = $pedido["useremail"];
        $this->viewData["total"] = $pedido["total"];

        $productos = ODAO::getProductsOrders($this->viewData["id"]);
        if (is_array($productos)) {
            foreach ($productos as &$producto) {
                $cantidad = (float)$producto["cantidad"];
                $precio = (float)$producto["precio_unitario"];
                $producto["subtotal"] = number_format($cantidad * $precio, 2, '.', '');
            }
            $this->viewData["productos"] = $productos;
        }

        Site::addLink("public/css/order.css");
        Renderer::render("Client/Order", $this->viewData);
    }
}
