<?php

class VentaPeer extends BaseVentaPeer
{
     public static function retrieveUltimoEstado($venta_id, $string = true) {
        $conexion= Propel::getConnection();
    	$consultaSql = 'SELECT %s, %s FROM %s WHERE %s = (SELECT MAX(%s) as %s FROM %s WHERE %s=%s GROUP BY %s)';
        $consultaSql = sprintf ($consultaSql, EstadoPeer::NOMBRE.' as ultimo_estado', EstadoPeer::ID.' as ultimo_estado_id', EstadoPeer::TABLE_NAME, EstadoPeer::ID, VentaEstadoPeer::ESTADO_ID, 'ultimo_estado', VentaEstadoPeer::TABLE_NAME, VentaEstadoPeer::VENTA_ID, $venta_id, VentaEstadoPeer::VENTA_ID);
    	$sentencia = $conexion->prepare ($consultaSql);

    	$sentencia->execute();
    	$resultSet = $sentencia->fetch (PDO::FETCH_OBJ);
    	return ($string) ? $resultSet->ultimo_estado : $resultSet->ultimo_estado_id;
    }
}
