<?php

class ProductoCategoriaPeer extends BaseProductoCategoriaPeer
{
  public static function retrieveCategorias () {
    $conexion= Propel::getConnection();
    $sql = sprintf('SELECT %s, %s FROM %s',
        ProductoCategoriaPeer::ID,
        ProductoCategoriaPeer::NOMBRE,
        ProductoCategoriaPeer::TABLE_NAME
    );

    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();

    $resultset = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return !empty($resultset) ? $resultset : null;
  }
}
