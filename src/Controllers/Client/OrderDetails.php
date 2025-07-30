<?php

namespace Controllers\Client;

use Controllers\PrivateController;
use Dao\Client\Orders as ODAO;
use Views\Renderer;
use Utilities\Site;

class OrderDetails extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "id" => 0,
            "fecha" => "",
            "estado" => "",
            "total" => "",
            "productos" => [],
            "nombre" => "",
            "correo" => "",
            "errors" => [],
            "readonly" => "readonly",
            "mode" => "DSP",
            "modeDsc" => "Detalle del pedido"
        ];
    }

    public function run(): void
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            Site::redirectToWithMsg("index.php?page=Client-OrderHistory", "ID de pedido inválido");
            return;
        }

        $this->viewData["id"] = intval($_GET["id"]);
        $usercod = $_SESSION["usercod"] ?? 0;

        // Obtener pedido solo si pertenece al usuario
        $pedido = ODAO::getOrdersById($this->viewData["id"]);

        if (!$pedido || $pedido["usercod"] != $usercod) {
            Site::redirectToWithMsg("index.php?page=Client-OrderHistory", "No tienes permiso para ver este pedido.");
            return;
        }

        $this->viewData["fecha"] = $pedido["fchpedido"];
        $this->viewData["estado"] = $pedido["estado"];
        $this->viewData["total"] = $pedido["total"];
        $this->viewData["nombre"] = $pedido["username"];
        $this->viewData["correo"] = $pedido["useremail"];

        $productos = ODAO::getProductsOrders($this->viewData["id"]);
        if (is_array($productos)) {
            foreach ($productos as &$producto) {
                $producto["subtotal"] = number_format($producto["cantidad"] * $producto["precio_unitario"], 2, ".", "");
            }
            $this->viewData["productos"] = $productos;
        }

        Renderer::render("Client/OrderDetails", $this->viewData);
    }
}
