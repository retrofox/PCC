<?php

class NotaPedidoPeer extends BaseNotaPedidoPeer
{
        public static function retrieveUltimoEstado($nota_pedido_id, $string = true) {
        $conexion= Propel::getConnection();
    	$consultaSql = 'SELECT %s, %s FROM %s WHERE %s = (SELECT MAX(%s) as %s FROM %s WHERE %s=%s GROUP BY %s)';
        $consultaSql = sprintf ($consultaSql, EstadoPeer::NOMBRE.' as ultimo_estado', EstadoPeer::ID.' as ultimo_estado_id', EstadoPeer::TABLE_NAME, EstadoPeer::ID, NotaPedidoEstadoPeer::ESTADO_ID, 'ultimo_estado', NotaPedidoEstadoPeer::TABLE_NAME, NotaPedidoEstadoPeer::NOTA_PEDIDO_ID, $nota_pedido_id, NotaPedidoEstadoPeer::NOTA_PEDIDO_ID);
    	$sentencia = $conexion->prepare ($consultaSql);

    	$sentencia->execute();
    	$resultSet = $sentencia->fetch (PDO::FETCH_OBJ);
    	return ($string) ? $resultSet->ultimo_estado : $resultSet->ultimo_estado_id;
    }
}
