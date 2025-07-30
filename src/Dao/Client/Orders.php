<?php

namespace Dao\Client;

use Dao\Table;

class Orders extends Table
{
    // Obtiene todos los pedidos con datos del usuario
    public static function getOrders(): array
    {
        $sqlstr = "SELECT u.username, p.pedidoId, p.fchpedido, p.estado, p.total 
                   FROM pedidos AS p 
                   INNER JOIN usuario AS u ON u.usercod = p.usercod";
        return self::obtenerRegistros($sqlstr, []);
    }

    // Obtiene un pedido específico con más detalle
    public static function getOrdersById(int $id)
    {
        $sqlstr = "SELECT u.username, u.useremail, p.pedidoId, p.fchpedido, p.estado, p.total 
                   FROM pedidos AS p 
                   INNER JOIN usuario AS u ON u.usercod = p.usercod 
                   WHERE p.pedidoId = :id";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    // Obtiene los productos de un pedido específico
    public static function getProductsOrders(int $id)
    {
        $sqlstr = "SELECT pr.productName, dp.cantidad, dp.precio_unitario 
                   FROM detalle_pedidos AS dp 
                   INNER JOIN productos AS pr ON dp.productoId = pr.productId 
                   WHERE dp.pedidoId = :id";
        return self::obtenerRegistros($sqlstr, ["id" => $id]);
    }

    // Actualiza el estado de un pedido
    public static function updateOrderStatus(int $id, string $estado)
    {
        $sqlstr = "UPDATE pedidos SET estado = :estado WHERE pedidoId = :id";
        return self::executeNonQuery($sqlstr, ["id" => $id, "estado" => $estado]);
    }

    public static function getOrdersByUser(int $usercod): array
    {
        $sqlstr = "SELECT pedidoId, fchpedido, estado, total 
               FROM pedidos 
               WHERE usercod = :usercod";
        return self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
    }

}
