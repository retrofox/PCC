<?php

/**
 * Compra form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCompraForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'producto_id'    => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'       => new sfWidgetFormInput(),
      'proveedor_id'   => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'nota_pedido_id' => new sfWidgetFormPropelChoice(array('model' => 'NotaPedido', 'add_empty' => true)),
      'precio'         => new sfWidgetFormInput(),
      'moneda'         => new sfWidgetFormInput(),
      'fecha'          => new sfWidgetFormDateTime(),
      'fecha_entrega'  => new sfWidgetFormDateTime(),
      'comentario'     => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Compra', 'column' => 'id', 'required' => false)),
      'producto_id'    => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'cantidad'       => new sfValidatorInteger(array('required' => false)),
      'proveedor_id'   => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'nota_pedido_id' => new sfValidatorPropelChoice(array('model' => 'NotaPedido', 'column' => 'id', 'required' => false)),
      'precio'         => new sfValidatorNumber(array('required' => false)),
      'moneda'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'fecha'          => new sfValidatorDateTime(array('required' => false)),
      'fecha_entrega'  => new sfValidatorDateTime(array('required' => false)),
      'comentario'     => new sfValidatorString(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('compra[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Compra';
  }


}
