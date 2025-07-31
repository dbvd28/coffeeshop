<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Accept extends PublicController
{
    public function run(): void
    {
        $dataview = array();

        // Validar existencia antes de uso
        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["orderid"] ?? "";

        if ($token !== "" && $token === $session_token) {
            $result = \Utilities\Paypal\PayPalCapture::captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }

        \Views\Renderer::render("paypal/accept", $dataview);
    }
}
