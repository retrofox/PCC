<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ProveedorFDP filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProveedorFDPFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fdp_id'       => new sfWidgetFormPropelChoice(array('model' => 'ProveedorFDP', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'fdp_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ProveedorFDP', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('proveedor_fdp_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProveedorFDP';
  }

  public function getFields()
  {
    return array(
      'proveedor_id' => 'ForeignKey',
      'fdp_id'       => 'ForeignKey',
      'id'           => 'Number',
    );
  }
}
