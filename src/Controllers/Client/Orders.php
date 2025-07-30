<?php

namespace Controllers\Client;

use Controllers\PrivateController;
use Dao\Client\Orders as ODAO;
use Views\Renderer;
use Utilities\Site as Site;

class Orders extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [];
    }

    public function run(): void
    {
        $userId = $_SESSION["usercod"] ?? 0; // Suponiendo que guardas ID usuario en sesión
        $this->viewData["pedidos"] = ODAO::getOrdersByUser($userId);

        Site::addLink("public/css/orders2.css");
        Renderer::render("Client/orders", $this->viewData);
    }
}
