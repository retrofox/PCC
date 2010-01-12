<?php

/**
 * ProductoUDM form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProductoUDMForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInput(),
      'unidad'           => new sfWidgetFormInput(),
      'unidad_mas_multi' => new sfWidgetFormInput(),
      'descripcion'      => new sfWidgetFormTextarea(),
      'dimension'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'ProductoUDM', 'column' => 'id', 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 50)),
      'unidad'           => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'unidad_mas_multi' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('required' => false)),
      'dimension'        => new sfValidatorString(array('max_length' => 15, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_udm[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoUDM';
  }


}
