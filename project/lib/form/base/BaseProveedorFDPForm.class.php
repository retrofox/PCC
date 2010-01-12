<?php

/**
 * ProveedorFDP form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProveedorFDPForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fdp_id'       => new sfWidgetFormPropelChoice(array('model' => 'ProveedorFDP', 'add_empty' => true)),
      'id'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'proveedor_id' => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'fdp_id'       => new sfValidatorPropelChoice(array('model' => 'ProveedorFDP', 'column' => 'id', 'required' => false)),
      'id'           => new sfValidatorPropelChoice(array('model' => 'ProveedorFDP', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveedor_fdp[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProveedorFDP';
  }


}
