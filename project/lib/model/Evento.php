<?php

class Evento extends BaseEvento
{
    /*
     * modifica el stock actual en la tabla productos
     */

    public function save(PropelPDO $con = null) {
        $producto = $this->getProducto();
        if($this->getOperacion()) $producto->incrementarStock($this->getCantidad());
        else $producto->decrementarStock($this->getCantidad());
        parent::save($con);
    }
}
