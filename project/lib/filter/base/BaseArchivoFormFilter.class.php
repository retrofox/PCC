<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Archivo filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseArchivoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                => new sfWidgetFormFilterInput(),
      'tipo'                  => new sfWidgetFormFilterInput(),
      'descripcion'           => new sfWidgetFormFilterInput(),
      'producto_archivo_list' => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'                => new sfValidatorPass(array('required' => false)),
      'tipo'                  => new sfValidatorPass(array('required' => false)),
      'descripcion'           => new sfValidatorPass(array('required' => false)),
      'producto_archivo_list' => new sfValidatorPropelChoice(array('model' => 'Producto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('archivo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(ProductoArchivoPeer::ARCHIVO_ID, ArchivoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductoArchivoPeer::PRODUCTO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductoArchivoPeer::PRODUCTO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Archivo';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'nombre'                => 'Text',
      'tipo'                  => 'Text',
      'descripcion'           => 'Text',
      'producto_archivo_list' => 'ManyKey',
    );
  }
}
