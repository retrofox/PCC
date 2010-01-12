<?php

/**
 * Archivo form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseArchivoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'nombre'                => new sfWidgetFormInput(),
      'tipo'                  => new sfWidgetFormInput(),
      'descripcion'           => new sfWidgetFormTextarea(),
      'producto_archivo_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Producto')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Archivo', 'column' => 'id', 'required' => false)),
      'nombre'                => new sfValidatorString(array('max_length' => 255)),
      'tipo'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descripcion'           => new sfValidatorString(array('required' => false)),
      'producto_archivo_list' => new sfValidatorPropelChoiceMany(array('model' => 'Producto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('archivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Archivo';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['producto_archivo_list']))
    {
      $values = array();
      foreach ($this->object->getProductoArchivos() as $obj)
      {
        $values[] = $obj->getProductoId();
      }

      $this->setDefault('producto_archivo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductoArchivoList($con);
  }

  public function saveProductoArchivoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['producto_archivo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProductoArchivoPeer::ARCHIVO_ID, $this->object->getPrimaryKey());
    ProductoArchivoPeer::doDelete($c, $con);

    $values = $this->getValue('producto_archivo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductoArchivo();
        $obj->setArchivoId($this->object->getPrimaryKey());
        $obj->setProductoId($value);
        $obj->save();
      }
    }
  }

}
