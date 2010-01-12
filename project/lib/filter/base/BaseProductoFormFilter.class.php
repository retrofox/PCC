<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Producto filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                  => new sfWidgetFormFilterInput(),
      'nombre'                  => new sfWidgetFormFilterInput(),
      'marca'                   => new sfWidgetFormFilterInput(),
      'descripcion'             => new sfWidgetFormFilterInput(),
      'producto_categoria_id'   => new sfWidgetFormPropelChoice(array('model' => 'ProductoCategoria', 'add_empty' => true)),
      'producto_udm_id'         => new sfWidgetFormPropelChoice(array('model' => 'ProductoUDM', 'add_empty' => true)),
      'ubicacion_fisica'        => new sfWidgetFormFilterInput(),
      'stock_actual'            => new sfWidgetFormFilterInput(),
      'stock_reservado'         => new sfWidgetFormFilterInput(),
      'stock_preaviso'          => new sfWidgetFormFilterInput(),
      'stock_critico'           => new sfWidgetFormFilterInput(),
      'producto_proveedor_list' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'producto_archivo_list'   => new sfWidgetFormPropelChoice(array('model' => 'Archivo', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'                  => new sfValidatorPass(array('required' => false)),
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'marca'                   => new sfValidatorPass(array('required' => false)),
      'descripcion'             => new sfValidatorPass(array('required' => false)),
      'producto_categoria_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ProductoCategoria', 'column' => 'id')),
      'producto_udm_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ProductoUDM', 'column' => 'id')),
      'ubicacion_fisica'        => new sfValidatorPass(array('required' => false)),
      'stock_actual'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_reservado'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_preaviso'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_critico'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'producto_proveedor_list' => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'required' => false)),
      'producto_archivo_list'   => new sfValidatorPropelChoice(array('model' => 'Archivo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addProductoProveedorListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductoProveedorPeer::PRODUCTO_ID, ProductoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductoProveedorPeer::PROVEEDOR_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductoProveedorPeer::PROVEEDOR_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addProductoArchivoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductoArchivoPeer::PRODUCTO_ID, ProductoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductoArchivoPeer::ARCHIVO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductoArchivoPeer::ARCHIVO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Producto';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'codigo'                  => 'Text',
      'nombre'                  => 'Text',
      'marca'                   => 'Text',
      'descripcion'             => 'Text',
      'producto_categoria_id'   => 'ForeignKey',
      'producto_udm_id'         => 'ForeignKey',
      'ubicacion_fisica'        => 'Text',
      'stock_actual'            => 'Number',
      'stock_reservado'         => 'Number',
      'stock_preaviso'          => 'Number',
      'stock_critico'           => 'Number',
      'producto_proveedor_list' => 'ManyKey',
      'producto_archivo_list'   => 'ManyKey',
    );
  }
}
