<?php

namespace Dao\Client;

use Dao\Table;

class Orders extends Table
{
    // En Dao/Client/Orders.php ya tienes:
    public static function getOrdersByUser(int $usercod): array
    {
        $sqlstr = "SELECT pedidoId, fchpedido, estado, total 
               FROM pedidos 
               WHERE usercod = :usercod
               ORDER BY fchpedido DESC";  // Ordenar por fecha descendente para historial
        return self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
    }


    public static function getOrdersById(int $id)
    {
        $sqlstr = "SELECT u.username, u.useremail, p.pedidoId, p.fchpedido, p.estado, p.total, p.usercod
                   FROM pedidos AS p
                   INNER JOIN usuario AS u ON u.usercod = p.usercod
                   WHERE p.pedidoId = :id";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    public static function getProductsOrders(int $id)
    {
        $sqlstr = "SELECT pr.productName, dp.cantidad, dp.precio_unitario 
                   FROM detalle_pedidos AS dp 
                   INNER JOIN productos AS pr ON dp.productoId = pr.productId 
                   WHERE dp.pedidoId = :id";
        return self::obtenerRegistros($sqlstr, ["id" => $id]);
    }

}
