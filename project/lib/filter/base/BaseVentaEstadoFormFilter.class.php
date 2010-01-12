<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * VentaEstado filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseVentaEstadoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'venta_id'      => new sfWidgetFormPropelChoice(array('model' => 'Venta', 'add_empty' => true)),
      'estado_id'     => new sfWidgetFormPropelChoice(array('model' => 'Estado', 'add_empty' => true)),
      'user_id'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormFilterInput(),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'venta_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Venta', 'column' => 'id')),
      'estado_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Estado', 'column' => 'id')),
      'user_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('venta_estado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentaEstado';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'venta_id'      => 'ForeignKey',
      'estado_id'     => 'ForeignKey',
      'user_id'       => 'ForeignKey',
      'observaciones' => 'Text',
      'fecha'         => 'Date',
    );
  }
}
