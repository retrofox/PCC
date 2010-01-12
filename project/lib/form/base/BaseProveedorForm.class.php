<?php

/**
 * Proveedor form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProveedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nombre'                  => new sfWidgetFormInput(),
      'cuit'                    => new sfWidgetFormInput(),
      'rubro_id'                => new sfWidgetFormPropelChoice(array('model' => 'ProveedorRubro', 'add_empty' => true)),
      'telefono'                => new sfWidgetFormInput(),
      'fax'                     => new sfWidgetFormInput(),
      'movil'                   => new sfWidgetFormInput(),
      'email'                   => new sfWidgetFormInput(),
      'persona_nombre'          => new sfWidgetFormInput(),
      'persona_apellido'        => new sfWidgetFormInput(),
      'direccion_calle'         => new sfWidgetFormInput(),
      'direccion_numero'        => new sfWidgetFormInput(),
      'direccion_manzana'       => new sfWidgetFormInput(),
      'direccion_barrio'        => new sfWidgetFormInput(),
      'direccion_piso'          => new sfWidgetFormInput(),
      'direccion_depto'         => new sfWidgetFormInput(),
      'localidad_id'            => new sfWidgetFormPropelChoice(array('model' => 'Localidad', 'add_empty' => true)),
      'provincia_id'            => new sfWidgetFormPropelChoice(array('model' => 'Provincia', 'add_empty' => true)),
      'producto_proveedor_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Producto')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'nombre'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cuit'                    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'rubro_id'                => new sfValidatorPropelChoice(array('model' => 'ProveedorRubro', 'column' => 'id', 'required' => false)),
      'telefono'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'fax'                     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'movil'                   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'email'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'persona_nombre'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'persona_apellido'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'direccion_calle'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'direccion_numero'        => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'direccion_manzana'       => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'direccion_barrio'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'direccion_piso'          => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'direccion_depto'         => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'localidad_id'            => new sfValidatorPropelChoice(array('model' => 'Localidad', 'column' => 'id', 'required' => false)),
      'provincia_id'            => new sfValidatorPropelChoice(array('model' => 'Provincia', 'column' => 'id', 'required' => false)),
      'producto_proveedor_list' => new sfValidatorPropelChoiceMany(array('model' => 'Producto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveedor';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['producto_proveedor_list']))
    {
      $values = array();
      foreach ($this->object->getProductoProveedors() as $obj)
      {
        $values[] = $obj->getProductoId();
      }

      $this->setDefault('producto_proveedor_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductoProveedorList($con);
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
    $c->add(ProductoProveedorPeer::PROVEEDOR_ID, $this->object->getPrimaryKey());
    ProductoProveedorPeer::doDelete($c, $con);

    $values = $this->getValue('producto_proveedor_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductoProveedor();
        $obj->setProveedorId($this->object->getPrimaryKey());
        $obj->setProductoId($value);
        $obj->save();
      }
    }
  }

}
