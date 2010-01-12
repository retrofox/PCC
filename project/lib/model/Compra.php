<?php

class Compra extends BaseCompra
{
    protected $es_compra_directa = false;

    public function getEsCompraDirecta () {
      return $this->es_compra_directa;
    }

    public function setEsCompraDirecta ($v) {
      $this->es_compra_directa = $v;
    }

    /*
     * Nos retorna el ultimo estado de una compra
     */
    public function getUltimoEstado ($string = true) {
        return CompraPeer::retrieveUltimoEstado($this->getId());
    }

    public function getUltimoEstadoId () {
        return CompraPeer::retrieveUltimoEstado($this->getId(), false);
    }

    public function save(PropelPDO $con = null)	{
        // Si el objeto compra tiene definida una nota de pedido agregamos algunas propiedades.
        if ($this->getNotaPedido()) {
            $this->setMoneda($this->getNotaPedido()->getTipoMoneda());
        };

        //die ('no vas a grabar ?');
        parent::save($con);
    }


    public function getTotalxCompra() {
        return ($this->getCantidad()*$this->getPrecio());
    }

    public function getTotalxCompraString() {
        return (CompraPeer::$simboloDeMoneda[$this->getMoneda()].' '.$this->getCantidad()*$this->getPrecio());
    }
    public function getUnidad() {
        return ($this->getProducto()->getProductoUDM() );
    }
    
}
