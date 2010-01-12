<?php

class ProductoPeer extends BaseProductoPeer {
  public static function recalcStock4Eventos($producto_id) {
    $conexion= Propel::getConnection();
    $consultaSql = 'SELECT  %s, SUM(%s) as valor FROM %s WHERE %s = %s GROUP BY %s';
    $consultaSql = sprintf ($consultaSql, EventoPeer::OPERACION.' as operacion', EventoPeer::CANTIDAD, EventoPeer::TABLE_NAME, EventoPeer::PRODUCTO_ID, $producto_id, EventoPeer::OPERACION );
    $sentencia = $conexion->prepare($consultaSql);
    $sentencia->execute();
    $valor=0;
    $arrayRes= array();
    while ($resultSet = $sentencia->fetch(PDO::FETCH_OBJ)) {
      if ($resultSet->operacion == 0)
	$valor=$valor-($resultSet->valor);
      else
	$valor=$valor+($resultSet->valor);
    };

    return $valor;
  }
  public static function recalcStock4Compras($producto_id) {
    $conexion= Propel::getConnection();
    $consultaSql = 'SELECT SUM(%s) as valor FROM %s JOIN %s ON %s = %s WHERE %s = %s AND (%s = 7 OR %s = 6 OR %s = 4)';
    $consultaSql = sprintf ($consultaSql, CompraPeer::CANTIDAD, CompraPeer::TABLE_NAME, CompraEstadoPeer::TABLE_NAME, CompraPeer::ID,  CompraEstadoPeer::COMPRA_ID, CompraPeer::PRODUCTO_ID,$producto_id, CompraEstadoPeer::ESTADO_ID,  CompraEstadoPeer::ESTADO_ID, CompraEstadoPeer::ESTADO_ID);
    $sentencia = $conexion->prepare($consultaSql);
    $sentencia->execute();
    $valor=0;
    $arrayRes= array();
    $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
    $valor=$resultSet->valor;
    return $valor;
  }
  public static function recalcStock4Ventas($producto_id) {
    $conexion= Propel::getConnection();
    $consultaSql = 'SELECT SUM(%s) as valor FROM %s JOIN %s ON %s = %s WHERE %s = %s AND (%s = 9 OR %s = 13)';
    $consultaSql = sprintf ($consultaSql, VentaPeer::CANTIDAD, VentaPeer::TABLE_NAME, VentaEstadoPeer::TABLE_NAME, VentaPeer::ID,  VentaEstadoPeer::VENTA_ID, VentaPeer::PRODUCTO_ID,$producto_id, VentaEstadoPeer::ESTADO_ID, VentaEstadoPeer::ESTADO_ID);
    $sentencia = $conexion->prepare($consultaSql);
    $sentencia->execute();
    $valor=0;
    $arrayRes= array();
    $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
    $valor=$resultSet->valor;
    return $valor;
  }
  public static function actualizarStock($producto_id, $cantidad, $operacion) {
    $producto = ProductoPeer::retrieveByPK($producto_id);
    $stock=$producto->getStockActual();
    if($operacion) $stock+=$cantidad;
    else $stock-=$cantidad;
    $producto->setStockActual($stock);
    $producto->save();
  }

  public static function retrieveWithoutNP ($nota_pedido_id) {
    $sql = 'SELECT %s ';
    $sql.= 'FROM %s ';
    $sql.= 'WHERE %s = %s';

    $sql = sprintf( $sql,
	CompraPeer::PRODUCTO_ID,
	CompraPeer::TABLE_NAME,
	CompraPeer::NOTA_PEDIDO_ID,
	$nota_pedido_id
    );

    $conexion= Propel::getConnection();
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $idExcluidos = array ();
    while ($resultSet = $sentencia->fetch(PDO::FETCH_ASSOC))
      array_push ($idExcluidos, $resultSet['PRODUCTO_ID']);

    $c = new Criteria ();
    $c->add(ProductoPeer::ID, $idExcluidos, Criteria::NOT_IN);
    $c->addAscendingOrderByColumn(ProductoPeer::NOMBRE);
    $productos = ProductoPeer::doSelect($c);
    return $productos;
  }
}
