<?php

class NotaPedido extends BaseNotaPedido
{
	public function __toString() {
		return $this->getNumero();
	}

    public function getProveedor () {
        return $this->getProveedorRelatedByProveedorId();
    }
    public function getTransporte () {
        return $this->getProveedorRelatedByTransporteId();
    }

    public function getUltimoEstado ($string = true) {
        return NotaPedidoPeer::retrieveUltimoEstado($this->getId());
    }

    public function getUltimoEstadoId () {
        return NotaPedidoPeer::retrieveUltimoEstado($this->getId(), false);
    }

    public function getTipoMoneda () {
        return $this->getFormasDePago()->getMoneda();
    }

    protected function doSave(PropelPDO $con) {
        // Seteamos el la fecha del plazo de entrega (fecha_plazo_entrega) siempre en funcion de la cantidad de días de entrega (plazo_entrega)
        $this->setFechaPlazoEntrega($this->calFechaPlazoEntrega($this->getFecha('d-m-Y'), $this->getPlazoEntrega()));
        parent::doSave($con);
    }


    /*
     * Este metodo tiene dos paramtros. Al la fecha (primer parametro) le suma una cierta cantidad de dias (segundo)
     * La fecha debe estar en fomato 'd-m-Y'.
     */
    function calFechaPlazoEntrega($fecha,$ndias) {
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))

        list($dia,$mes,$año)=split("/", $fecha);

        if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))

        list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);

        return ($nuevafecha);
    }
    public function getProductosWithoutNP($np='') {
	    $np = ($np != '') ? $np : $this->getId();
		$productos = CompraPeer::retrieveWithoutNP($np);
        return $productos;
	}
}
