<?php

/**
 * CompraEstado form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCompraEstadoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'compra_id'         => new sfWidgetFormPropelChoice(array('model' => 'Compra', 'add_empty' => true)),
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'estado_id'         => new sfWidgetFormPropelChoice(array('model' => 'Estado', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormInput(),
      'fecha'             => new sfWidgetFormDateTime(),
      'observaciones'     => new sfWidgetFormTextarea(),
      'nota_recepcion_id' => new sfWidgetFormPropelChoice(array('model' => 'RecepcionPedido', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'CompraEstado', 'column' => 'id', 'required' => false)),
      'compra_id'         => new sfValidatorPropelChoice(array('model' => 'Compra', 'column' => 'id', 'required' => false)),
      'user_id'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'estado_id'         => new sfValidatorPropelChoice(array('model' => 'Estado', 'column' => 'id', 'required' => false)),
      'cantidad'          => new sfValidatorInteger(array('required' => false)),
      'fecha'             => new sfValidatorDateTime(array('required' => false)),
      'observaciones'     => new sfValidatorString(array('required' => false)),
      'nota_recepcion_id' => new sfValidatorPropelChoice(array('model' => 'RecepcionPedido', 'column' => 'id', 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('compra_estado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompraEstado';
  }


}
