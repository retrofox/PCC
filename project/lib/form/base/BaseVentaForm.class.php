<?php

/**
 * Venta form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseVentaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'producto_id'              => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'                 => new sfWidgetFormInput(),
      'numero_remito'            => new sfWidgetFormInput(),
      'transportista_interno_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'transportista_externo_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fecha'                    => new sfWidgetFormDateTime(),
      'comentario'               => new sfWidgetFormTextarea(),
      'created_at'               => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorPropelChoice(array('model' => 'Venta', 'column' => 'id', 'required' => false)),
      'producto_id'              => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'cantidad'                 => new sfValidatorInteger(array('required' => false)),
      'numero_remito'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'transportista_interno_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'transportista_externo_id' => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'fecha'                    => new sfValidatorDateTime(array('required' => false)),
      'comentario'               => new sfValidatorString(array('required' => false)),
      'created_at'               => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('venta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Venta';
  }


}
