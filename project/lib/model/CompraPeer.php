<?php

class CompraPeer extends BaseCompraPeer
{
    static public $monedas = array (
        'peso' => 'peso',
        'dolar' => 'dolar',
        'euro' => 'euro'
    );

    static public $simboloDeMoneda = array (
        'peso'  => '$',
        'dolar' => 'U$s',
        'euro'  => '€'
    );
    
    public static function retrieveUltimoEstado($compra_id, $string = true) {
        $conexion= Propel::getConnection();
    	$consultaSql = 'SELECT %s, %s FROM %s WHERE %s = (SELECT MAX(%s) as %s FROM %s WHERE %s=%s GROUP BY %s)';
        $consultaSql = sprintf ($consultaSql, EstadoPeer::NOMBRE.' as ultimo_estado', EstadoPeer::ID.' as ultimo_estado_id', EstadoPeer::TABLE_NAME, EstadoPeer::ID, CompraEstadoPeer::ESTADO_ID, 'ultimo_estado', CompraEstadoPeer::TABLE_NAME, CompraEstadoPeer::COMPRA_ID, $compra_id, CompraEstadoPeer::COMPRA_ID);
    	$sentencia = $conexion->prepare ($consultaSql);

    	$sentencia->execute();
    	$resultSet = $sentencia->fetch (PDO::FETCH_OBJ);
    	return ($string) ? $resultSet->ultimo_estado : $resultSet->ultimo_estado_id;
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
    	$resultSet = $sentencia->fetch(PDO::FETCH_ASSOC);
 	 	$idExcluidos = array ();

 	 	foreach ($resultSet as $registro) {
 	 		array_push ($idExcluidos, $registro['PRODUCTO_ID']);
 	 	}

		$c = new Criteria ();
		$c->add(ProductoPeer::ID, $idExcluidos, Criteria::NOT_IN);
		$c->addAscendingOrderByColumn(ProductoPeer::NOMBRE);
		$productos = ProductoPeer::doSelect($c);
		return $productos;
	}
}
