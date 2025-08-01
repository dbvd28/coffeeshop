<?php

namespace Controllers\Administrator;

use Controllers\PrivateController;
use Controllers\PublicController;
use Dao\Administrator\Products as ProductDAO;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;

const LIST_URL = "index.php?page=Administrator-ProductsList";

class Products extends PrivateController
{
    private array $viewData;
    private array $modes;
    private array $errors;

    public function __construct()
    {
        parent::__construct();

        $this->viewData = [
            "mode" => "",
            "modeDesc" => "",
            "productId" => 0,
            "productName" => "",
            "productDescription" => "",
            "productPrice" => "",
            "productImgUrl" => "",
            "productStock" => "",
            "productStatus" => "ACT",
            "errors" => [],
            "xsrfToken" => ""
        ];

        $this->errors = [];

        $this->modes = [
            "INS" => "Nuevo Producto",
            "UPD" => "Editar Producto",
            "DSP" => "Detalle de Producto"
        ];
    }

    public function run(): void
    {
        $this->getQueryParams();

        if ($this->viewData["mode"] !== "INS") {
            $this->loadData();
        }

        if ($this->isPostBack()) {
            $this->getPostData();

            if ($this->validate()) {
                $this->saveData();
            }
        }

        $this->prepareView();
        Renderer::render("Administrator/product", $this->viewData);
    }

    private function getQueryParams(): void
    {
        if (!isset($_GET["mode"]) || !isset($this->modes[$_GET["mode"]])) {
            Site::redirectToWithMsg(LIST_URL, "Modo inválido");
        }
        $this->viewData["mode"] = $_GET["mode"];
        $this->viewData["modeDesc"] = $this->modes[$this->viewData["mode"]];

        if ($this->viewData["mode"] !== "INS") {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                Site::redirectToWithMsg(LIST_URL, "ID inválido");
            }
            $this->viewData["productId"] = intval($_GET["id"]);
        }
    }

    private function loadData(): void
    {
        $product = ProductDAO::getById($this->viewData["productId"]);
        if (!$product) {
            Site::redirectToWithMsg(LIST_URL, "Producto no encontrado");
        }
        $this->viewData = array_merge($this->viewData, $product);
    }

    private function getPostData(): void
    {
        $this->viewData["productName"] = $_POST["productName"] ?? "";
        $this->viewData["productDescription"] = $_POST["productDescription"] ?? "";
        $this->viewData["productPrice"] = $_POST["productPrice"] ?? "";
        $this->viewData["productImgUrl"] = $_POST["productImgUrl"] ?? "";
        $this->viewData["productStock"] = $_POST["productStock"] ?? "";
        $this->viewData["productStatus"] = $_POST["productStatus"] ?? "INA";

        // Validar xsrf token
        $postToken = $_POST["xsrfToken"] ?? "";
        if ($postToken !== $_SESSION[$this->name . "-xsrfToken"] ?? "") {
            $this->errors["global"] = "Token de seguridad inválido.";
        }
    }

    private function validate(): bool
    {
        if (empty($this->viewData["productName"])) {
            $this->errors["productName"] = "El nombre es obligatorio.";
        }
        if (empty($this->viewData["productDescription"])) {
            $this->errors["productDescription"] = "La descripción es obligatoria.";
        }
        if (!is_numeric($this->viewData["productPrice"]) || floatval($this->viewData["productPrice"]) < 0) {
            $this->errors["productPrice"] = "El precio debe ser un número positivo.";
        }
        if (empty($this->viewData["productImgUrl"])) {
            $this->errors["productImgUrl"] = "La URL de la imagen es obligatoria.";
        }
        if (!is_numeric($this->viewData["productStock"]) || intval($this->viewData["productStock"]) < 0) {
            $this->errors["productStock"] = "El stock debe ser un número entero no negativo.";
        }
        if (!in_array($this->viewData["productStatus"], ["ACT", "INA", "DES"])) {
            $this->errors["productStatus"] = "Estado inválido.";
        }

        $this->viewData["errors"] = $this->errors;
        return count($this->errors) === 0;
    }

    private function saveData(): void
    {
        $data = [
            "productName" => $this->viewData["productName"],
            "productDescription" => $this->viewData["productDescription"],
            "productPrice" => floatval($this->viewData["productPrice"]),
            "productImgUrl" => $this->viewData["productImgUrl"],
            "productStock" => intval($this->viewData["productStock"]),
            "productStatus" => $this->viewData["productStatus"],
        ];

        if ($this->viewData["mode"] === "INS") {
            if (ProductDAO::insert($data)) {
                Site::redirectToWithMsg(LIST_URL, "Producto creado correctamente");
            } else {
                $this->errors["global"] = "Error al crear el producto.";
            }
        } elseif ($this->viewData["mode"] === "UPD") {
            if (ProductDAO::update($this->viewData["productId"], $data)) {
                Site::redirectToWithMsg(LIST_URL, "Producto actualizado correctamente");
            } else {
                $this->errors["global"] = "Error al actualizar el producto.";
            }
        }
    }

    private function prepareView(): void
    {
        // Generar nuevo token xsrf para el formulario
        $this->viewData["xsrfToken"] = hash("sha256", json_encode($this->viewData));
        $_SESSION[$this->name . "-xsrfToken"] = $this->viewData["xsrfToken"];
    }
}
