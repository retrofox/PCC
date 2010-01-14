<?php

class ProductoUDMPeer extends BaseProductoUDMPeer
{
  public static function retrieveUDMs () {
    $conexion= Propel::getConnection();
    $sql = sprintf('SELECT %s, %s FROM %s',
        ProductoUDMPeer::ID,
        ProductoUDMPeer::NOMBRE,
        ProductoUDMPeer::TABLE_NAME
    );

    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();

    $resultset = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return !empty($resultset) ? $resultset : null;
  }
}
