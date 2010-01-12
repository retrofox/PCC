<?php

class CompraEstado extends BaseCompraEstado
{
    /*
     * modifica el stock actual en la tabla productos
     * cuando el estado es 7, 6 ó 4
     */

    public function save(PropelPDO $con = null) {
        $compra = $this->getCompra();
        $producto = $compra->getProducto();
        if ($this->getEstadoId()==7 || $this->getEstadoId()==6 || $this->getEstadoId()==4)
        $producto->incrementarStock($this->getCantidad());
        parent::save($con);
    }
}
