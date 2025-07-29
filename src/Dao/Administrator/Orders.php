<?php

namespace Dao\Administrator;

use Dao\Table;

class Orders extends Table
{

    public static function getOrders(): array
    {
        $sqlstr = "SELECT u.username, p.pedidoId,p.fchpedido,p.estado,p.total FROM pedidos as p inner join usuario as u WHERE u.usercod=p.usercod";
        return self::obtenerRegistros(
            $sqlstr,
            []
        );
    }

    public static function getOrdersById(int $id)
    {
        $sqlstr = "SELECT u.username,u.useremail, p.pedidoId,p.fchpedido,p.estado,p.total FROM pedidos as p inner join usuario as u WHERE pedidoId=:id and u.usercod = p.usercod";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }
    public static function getProductsOrders(int $id)
    {
        $sqlstr = "SELECT pr.productName,dp.cantidad,dp.precio_unitario from detalle_pedidos as dp inner join productos as pr where dp.productoId=pr.productId and  dp.pedidoId=:id";
        return self::obtenerRegistros($sqlstr, ["id" => $id]);
    }
    public static function updateOrderStatus(int $id, string $estado)
    {
        $sqlstr = "UPDATE pedidos SET estado=:estado WHERE pedidoId=:id";
        return self::executeNonQuery($sqlstr, ["id" => $id, "estado" => $estado]);
    }
}