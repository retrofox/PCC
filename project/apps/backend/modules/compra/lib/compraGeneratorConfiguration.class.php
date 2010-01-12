<?php

/**
 * compra module configuration.
 *
 * @package    pcc
 * @subpackage compra
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class compraGeneratorConfiguration extends BaseCompraGeneratorConfiguration
{
  public function get4ProductoForm($object = null) {
    $class = $this->get4ProductoFormClass();
    return new $class($object, $this->getFormOptions());
  }

  public function get4ProductoFormClass() {
    return 'Compra4ProductoForm';
  }

  public function get4NotaPedidoForm($object = null) {
    $class = $this->get4NotaPedidoFormClass();
    return new $class($object, $this->getFormOptions());
  }

  public function get4NotaPedidoFormClass() {
    return 'Compra4NotaPedidoForm';
  }
}
