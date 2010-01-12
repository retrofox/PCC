<?php

/**
 * VentaEstado form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseVentaEstadoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'venta_id'      => new sfWidgetFormPropelChoice(array('model' => 'Venta', 'add_empty' => true)),
      'estado_id'     => new sfWidgetFormPropelChoice(array('model' => 'Estado', 'add_empty' => true)),
      'user_id'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormTextarea(),
      'fecha'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'VentaEstado', 'column' => 'id', 'required' => false)),
      'venta_id'      => new sfValidatorPropelChoice(array('model' => 'Venta', 'column' => 'id', 'required' => false)),
      'estado_id'     => new sfValidatorPropelChoice(array('model' => 'Estado', 'column' => 'id', 'required' => false)),
      'user_id'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'fecha'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('venta_estado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentaEstado';
  }


}
