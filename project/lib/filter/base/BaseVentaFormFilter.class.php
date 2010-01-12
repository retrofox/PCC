<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Venta filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseVentaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'producto_id'              => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'                 => new sfWidgetFormFilterInput(),
      'numero_remito'            => new sfWidgetFormFilterInput(),
      'transportista_interno_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'transportista_externo_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fecha'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'comentario'               => new sfWidgetFormFilterInput(),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'producto_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'cantidad'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'numero_remito'            => new sfValidatorPass(array('required' => false)),
      'transportista_interno_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'transportista_externo_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'fecha'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'comentario'               => new sfValidatorPass(array('required' => false)),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('venta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Venta';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'producto_id'              => 'ForeignKey',
      'cantidad'                 => 'Number',
      'numero_remito'            => 'Text',
      'transportista_interno_id' => 'ForeignKey',
      'transportista_externo_id' => 'ForeignKey',
      'fecha'                    => 'Date',
      'comentario'               => 'Text',
      'created_at'               => 'Date',
    );
  }
}
