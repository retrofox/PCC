<?php

class RecepcionPedido extends BaseRecepcionPedido
{
    public function getRecibe ($string = true) {
        return $this->getsfGuardUserRelatedByRecibeId()->getProfile();
    }
  public function getTransportista () {
        return $this->getProveedor();
    }
}
