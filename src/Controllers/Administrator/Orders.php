<?php 

namespace Controllers\Administrator;

use Controllers\PrivateController;
use Dao\Administrator\Orders as ODAO;
use Views\Renderer;
class Orders extends PrivateController{
    private array $viewData;
    public function __construct(){
        parent::__construct();
        $this->viewData=[];
    }
    public function run():void{
       // $this->viewData["categories"]=CategoriesDao::getCategories();
    Renderer::render("Administrator/orders",$this->viewData);
    }
}