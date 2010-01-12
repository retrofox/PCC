<?php

/**
 * ProductoProveedor form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProductoProveedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'producto_id'  => new sfWidgetFormInputHidden(),
      'proveedor_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'producto_id'  => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'proveedor_id' => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoProveedor';
  }


}
