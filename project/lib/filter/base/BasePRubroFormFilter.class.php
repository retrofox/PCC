<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * PRubro filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BasePRubroFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'rubro' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'rubro' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('p_rubro_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PRubro';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'rubro' => 'Text',
    );
  }
}
