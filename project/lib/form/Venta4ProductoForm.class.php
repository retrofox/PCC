<?php

/**
 * Venta form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class Venta4ProductoForm extends VentaForm {

  public function configure() {
    $this->widgetSchema['producto_id'] = new sfWidgetFormInputHidden ();
    parent::configure();

    $this->setDefault('is4Producto', 'true');
  }

}
