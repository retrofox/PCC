<?php

/**
 * Producto form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'codigo'                  => new sfWidgetFormInput(),
      'nombre'                  => new sfWidgetFormInput(),
      'marca'                   => new sfWidgetFormInput(),
      'descripcion'             => new sfWidgetFormTextarea(),
      'producto_categoria_id'   => new sfWidgetFormPropelChoice(array('model' => 'ProductoCategoria', 'add_empty' => true)),
      'producto_udm_id'         => new sfWidgetFormPropelChoice(array('model' => 'ProductoUDM', 'add_empty' => true)),
      'ubicacion_fisica'        => new sfWidgetFormInput(),
      'stock_actual'            => new sfWidgetFormInput(),
      'stock_reservado'         => new sfWidgetFormInput(),
      'stock_preaviso'          => new sfWidgetFormInput(),
      'stock_critico'           => new sfWidgetFormInput(),
      'producto_proveedor_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Proveedor')),
      'producto_archivo_list'   => new sfWidgetFormPropelChoiceMany(array('model' => 'Archivo')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'codigo'                  => new sfValidatorString(array('max_length' => 20)),
      'nombre'                  => new sfValidatorString(array('max_length' => 100)),
      'marca'                   => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'descripcion'             => new sfValidatorString(array('required' => false)),
      'producto_categoria_id'   => new sfValidatorPropelChoice(array('model' => 'ProductoCategoria', 'column' => 'id', 'required' => false)),
      'producto_udm_id'         => new sfValidatorPropelChoice(array('model' => 'ProductoUDM', 'column' => 'id', 'required' => false)),
      'ubicacion_fisica'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'stock_actual'            => new sfValidatorInteger(array('required' => false)),
      'stock_reservado'         => new sfValidatorInteger(array('required' => false)),
      'stock_preaviso'          => new sfValidatorInteger(array('required' => false)),
      'stock_critico'           => new sfValidatorInteger(array('required' => false)),
      'producto_proveedor_list' => new sfValidatorPropelChoiceMany(array('model' => 'Proveedor', 'required' => false)),
      'producto_archivo_list'   => new sfValidatorPropelChoiceMany(array('model' => 'Archivo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Producto';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['producto_proveedor_list']))
    {
      $values = array();
      foreach ($this->object->getProductoProveedors() as $obj)
      {
        $values[] = $obj->getProveedorId();
      }

      $this->setDefault('producto_proveedor_list', $values);
    }

    if (isset($this->widgetSchema['producto_archivo_list']))
    {
      $values = array();
      foreach ($this->object->getProductoArchivos() as $obj)
      {
        $values[] = $obj->getArchivoId();
      }

      $this->setDefault('producto_archivo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductoProveedorList($con);
    $this->saveProductoArchivoList($con);
  }

  public function saveProductoProveedorList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['producto_proveedor_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProductoProveedorPeer::PRODUCTO_ID, $this->object->getPrimaryKey());
    ProductoProveedorPeer::doDelete($c, $con);

    $values = $this->getValue('producto_proveedor_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductoProveedor();
        $obj->setProductoId($this->object->getPrimaryKey());
        $obj->setProveedorId($value);
        $obj->save();
      }
    }
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
    $c->add(ProductoArchivoPeer::PRODUCTO_ID, $this->object->getPrimaryKey());
    ProductoArchivoPeer::doDelete($c, $con);

    $values = $this->getValue('producto_archivo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductoArchivo();
        $obj->setProductoId($this->object->getPrimaryKey());
        $obj->setArchivoId($value);
        $obj->save();
      }
    }
  }

}
