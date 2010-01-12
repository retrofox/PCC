<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Proveedor filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProveedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                  => new sfWidgetFormFilterInput(),
      'cuit'                    => new sfWidgetFormFilterInput(),
      'rubro_id'                => new sfWidgetFormPropelChoice(array('model' => 'ProveedorRubro', 'add_empty' => true)),
      'telefono'                => new sfWidgetFormFilterInput(),
      'fax'                     => new sfWidgetFormFilterInput(),
      'movil'                   => new sfWidgetFormFilterInput(),
      'email'                   => new sfWidgetFormFilterInput(),
      'persona_nombre'          => new sfWidgetFormFilterInput(),
      'persona_apellido'        => new sfWidgetFormFilterInput(),
      'direccion_calle'         => new sfWidgetFormFilterInput(),
      'direccion_numero'        => new sfWidgetFormFilterInput(),
      'direccion_manzana'       => new sfWidgetFormFilterInput(),
      'direccion_barrio'        => new sfWidgetFormFilterInput(),
      'direccion_piso'          => new sfWidgetFormFilterInput(),
      'direccion_depto'         => new sfWidgetFormFilterInput(),
      'localidad_id'            => new sfWidgetFormPropelChoice(array('model' => 'Localidad', 'add_empty' => true)),
      'provincia_id'            => new sfWidgetFormPropelChoice(array('model' => 'Provincia', 'add_empty' => true)),
      'producto_proveedor_list' => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'cuit'                    => new sfValidatorPass(array('required' => false)),
      'rubro_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ProveedorRubro', 'column' => 'id')),
      'telefono'                => new sfValidatorPass(array('required' => false)),
      'fax'                     => new sfValidatorPass(array('required' => false)),
      'movil'                   => new sfValidatorPass(array('required' => false)),
      'email'                   => new sfValidatorPass(array('required' => false)),
      'persona_nombre'          => new sfValidatorPass(array('required' => false)),
      'persona_apellido'        => new sfValidatorPass(array('required' => false)),
      'direccion_calle'         => new sfValidatorPass(array('required' => false)),
      'direccion_numero'        => new sfValidatorPass(array('required' => false)),
      'direccion_manzana'       => new sfValidatorPass(array('required' => false)),
      'direccion_barrio'        => new sfValidatorPass(array('required' => false)),
      'direccion_piso'          => new sfValidatorPass(array('required' => false)),
      'direccion_depto'         => new sfValidatorPass(array('required' => false)),
      'localidad_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Localidad', 'column' => 'id')),
      'provincia_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Provincia', 'column' => 'id')),
      'producto_proveedor_list' => new sfValidatorPropelChoice(array('model' => 'Producto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveedor_filters[%s]');

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

    $criteria->addJoin(ProductoProveedorPeer::PROVEEDOR_ID, ProveedorPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductoProveedorPeer::PRODUCTO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductoProveedorPeer::PRODUCTO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Proveedor';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'nombre'                  => 'Text',
      'cuit'                    => 'Text',
      'rubro_id'                => 'ForeignKey',
      'telefono'                => 'Text',
      'fax'                     => 'Text',
      'movil'                   => 'Text',
      'email'                   => 'Text',
      'persona_nombre'          => 'Text',
      'persona_apellido'        => 'Text',
      'direccion_calle'         => 'Text',
      'direccion_numero'        => 'Text',
      'direccion_manzana'       => 'Text',
      'direccion_barrio'        => 'Text',
      'direccion_piso'          => 'Text',
      'direccion_depto'         => 'Text',
      'localidad_id'            => 'ForeignKey',
      'provincia_id'            => 'ForeignKey',
      'producto_proveedor_list' => 'ManyKey',
    );
  }
}
