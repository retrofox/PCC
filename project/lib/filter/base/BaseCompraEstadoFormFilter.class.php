<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * CompraEstado filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCompraEstadoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'compra_id'         => new sfWidgetFormPropelChoice(array('model' => 'Compra', 'add_empty' => true)),
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'estado_id'         => new sfWidgetFormPropelChoice(array('model' => 'Estado', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormFilterInput(),
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'observaciones'     => new sfWidgetFormFilterInput(),
      'nota_recepcion_id' => new sfWidgetFormPropelChoice(array('model' => 'RecepcionPedido', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'compra_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Compra', 'column' => 'id')),
      'user_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'estado_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Estado', 'column' => 'id')),
      'cantidad'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones'     => new sfValidatorPass(array('required' => false)),
      'nota_recepcion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RecepcionPedido', 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('compra_estado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompraEstado';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'compra_id'         => 'ForeignKey',
      'user_id'           => 'ForeignKey',
      'estado_id'         => 'ForeignKey',
      'cantidad'          => 'Number',
      'fecha'             => 'Date',
      'observaciones'     => 'Text',
      'nota_recepcion_id' => 'ForeignKey',
      'created_at'        => 'Date',
    );
  }
}
