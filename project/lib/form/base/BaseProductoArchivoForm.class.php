<?php

/**
 * ProductoArchivo form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProductoArchivoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'producto_id' => new sfWidgetFormInputHidden(),
      'archivo_id'  => new sfWidgetFormInputHidden(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'producto_id' => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'archivo_id'  => new sfValidatorPropelChoice(array('model' => 'Archivo', 'column' => 'id', 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_archivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoArchivo';
  }


}
