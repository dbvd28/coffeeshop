<?php

namespace Controllers\Client;

use Controllers\PrivateController;
use Dao\Client\Orders as ODAO;
use Views\Renderer;
use Utilities\Site;

class Orders extends PrivateController
{
    private array $viewData;
    public function __construct()
    {
        parent::__construct();
        $this->viewData = [];
        $this->viewData["isUpdateEnabled"] = parent::isFeatureAutorized($this->name . "\update");
    }
    public function run(): void
    {
        $usercod = $_SESSION["usercod"];
        $this->viewData["pedidos"] = ODAO::getOrdersByUser($usercod);
        Site::addLink("public/css/orders2.css");
        Renderer::render("Client/orders", $this->viewData);
    }
}