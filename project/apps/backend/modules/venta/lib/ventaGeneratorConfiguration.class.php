<?php

/**
 * venta module configuration.
 *
 * @package    pcc
 * @subpackage venta
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ventaGeneratorConfiguration extends BaseVentaGeneratorConfiguration {
  
  public function get4ProductoForm($object = null) {
    $class = $this->get4ProductoFormClass();
    return new $class($object, $this->getFormOptions());
  }

  public function get4ProductoFormClass() {
    return 'Venta4ProductoForm';
  }
}
