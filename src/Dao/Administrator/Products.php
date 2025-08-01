<?php

namespace Dao\Administrator;

use Dao\Table;

class Products extends Table
{
    public static function getAll(): array
    {
        return self::obtenerRegistros("SELECT * FROM productos", []);
    }

    public static function getById(int $id): array
    {
        return self::obtenerUnRegistro("SELECT * FROM productos WHERE productId = :id", ["id" => $id]);
    }

    public static function insert(array $data): bool
    {
        $sql = "INSERT INTO productos (productName, productDescription, productPrice, productImgUrl, productStock, productStatus)
                VALUES (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus)";
        return self::executeNonQuery($sql, $data);
    }

    public static function update(int $id, array $data): bool
    {
        $data["productId"] = $id;
        $sql = "UPDATE productos SET
                    productName = :productName,
                    productDescription = :productDescription,
                    productPrice = :productPrice,
                    productImgUrl = :productImgUrl,
                    productStock = :productStock,
                    productStatus = :productStatus
                WHERE productId = :productId";
        return self::executeNonQuery($sql, $data);
    }
}
