<?php

class VentaEstado extends BaseVentaEstado
{
     /*
     * modifica el stock actual en la tabla productos
     * cuando el estado es 9 o 13
     */

    public function save(PropelPDO $con = null) {
        $venta = $this->getVenta();
        $producto = $venta->getProducto();
        $cantidad = $venta->getCantidad();
        if ($this->getEstadoId()==9 || $this->getEstadoId()==13)
        $producto->decrementarStock($cantidad);
        parent::save($con);
    }
}
