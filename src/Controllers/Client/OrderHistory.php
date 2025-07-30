<?php

namespace Controllers\Client;

use Controllers\PrivateController;
use Dao\Client\Orders as ODAO;
use Views\Renderer;
use Utilities\Site;

class OrderHistory extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [];
    }

    public function run(): void
    {
        // Obtener usercod desde sesión
        $usercod = $_SESSION['usercod'] ?? 0;
        if ($usercod === 0) {
            Site::redirectToWithMsg("index.php?page=Sec_Login", "Debe iniciar sesión para ver su historial.");
            return;
        }

        // Obtener pedidos del usuario
        $this->viewData["historial"] = ODAO::getOrdersByUser($usercod);

        // Añadir estilos específicos si quieres
        Site::addLink("public/css/orderhistory.css");

        // Renderizar vista
        Renderer::render("Client/OrderHistory", $this->viewData);
    }
}
