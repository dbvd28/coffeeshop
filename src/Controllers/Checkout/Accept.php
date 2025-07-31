<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Administrator\Orders;
use Utilities\Security;
class Accept extends PublicController
{
    public function run(): void
    {/*
      $dataview = array();
       $token = $_GET["token"] ?: "";
       $session_token = $_SESSION["orderid"] ?: "";
       if ($token !== "" && $token == $session_token) {
           $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
               \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
               \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
           );
           $result = $PayPalRestApi->captureOrder($session_token);
          
           $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
       } else {
           $dataview["orderjson"] = "No Order Available!!!";
       }
       \Views\Renderer::render("paypal/accept", $dataview);*/

        $dataview = array();
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
            $orderId=Orders::addOrder(Security::getUserId(),floatval($amount),$archivo);
            Orders::transferTempCartToOrder(Security::getUserId(),$orderId);
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }
        \Views\Renderer::render("paypal/accept", $dataview);

    }
}
