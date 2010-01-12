<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ProductoStock filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseProductoStockFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'stock_actual'    => new sfWidgetFormFilterInput(),
      'stock_critico'   => new sfWidgetFormFilterInput(),
      'stock_preaviso'  => new sfWidgetFormFilterInput(),
      'stock_reservado' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'stock_actual'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_critico'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_preaviso'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_reservado' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_stock_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoStock';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'stock_actual'    => 'Number',
      'stock_critico'   => 'Number',
      'stock_preaviso'  => 'Number',
      'stock_reservado' => 'Number',
    );
  }
}
