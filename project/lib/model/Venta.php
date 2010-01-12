<?php

class Venta extends BaseVenta
{
   /*
     * Nos retorna el ultimo estado de una venta
     */
    public function getUltimoEstado ($string = true) {
        return VentaPeer::retrieveUltimoEstado($this->getId());
    }

    public function getUltimoEstadoId () {
        return VentaPeer::retrieveUltimoEstado($this->getId(), false);
    }

    public function getTransportistaInterno () {
        return $this->getsfGuardUser()->getProfile();
    }
    public function getTransportistaExterno () {
        return $this->getProveedor();
    }
}
