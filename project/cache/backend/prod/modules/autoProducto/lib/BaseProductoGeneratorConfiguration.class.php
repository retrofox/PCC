<?php

/**
 * producto module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage producto
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 12831 2008-11-09 14:33:38Z fabien $
 */
class BaseProductoGeneratorConfiguration extends sfModelGeneratorConfiguration
{
  public function getCredentials($action)
  {
    if (0 === strpos($action, '_'))
    {
      $action = substr($action, 1);
    }

    return isset($this->configuration['credentials'][$action]) ? $this->configuration['credentials'][$action] : array();
  }

  public function getActionsDefault()
  {
    return array();
  }

  public function getFormActions()
  {
    return array(  '_delete' => NULL,  '_list' => NULL,  '_save' => NULL,  '_save_and_add' => NULL,);
  }

  public function getNewActions()
  {
    return array();
  }

  public function getEditActions()
  {
    return array();
  }

  public function getListObjectActions()
  {
    return array(  '_edit' =>   array(    'inWinPopUp' => true,  ),  '_delete' => NULL,  'evento' =>   array(    'inWinPopUp' => true,    'label' => 'Agregar Evento',    'winType' => 'newWin',  ),  'comprar' =>   array(    'inWinPopUp' => true,    'label' => 'Agregar Compra',    'winType' => 'newWin',  ),  'venta' =>   array(    'inWinPopUp' => true,    'label' => 'Realizar Venta',    'winType' => 'newWin',  ),  'recalc' =>   array(    'inWinPopUp' => true,    'label' => 'Stock de Producto',    'dims' => '400xautox100x50',  ),);
  }

  public function getListActions()
  {
    return array(  '_new' =>   array(    'inWinPopUp' => true,  ),);
  }

  public function getListBatchActions()
  {
    return array(  '_delete' => NULL,);
  }

  public function getListParams()
  {
    return '%%id%% - %%codigo%% - %%nombre%% - %%stock_actual%% - %%ubicacion_fisica%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'Product List';
  }

  public function getEditTitle()
  {
    return 'Edit Product';
  }

  public function getNewTitle()
  {
    return 'New Product';
  }

  public function getFilterDisplay()
  {
    return array(  0 => 'codigo',  1 => 'nombre',  2 => 'producto_categoria_id',  3 => 'ubicacion_fisica',  4 => 'producto_categoria_id',  5 => 'producto_proveedor_list',);
  }

  public function getFormDisplay()
  {
    return array(  'Datos Principales' =>   array(    0 => 'codigo',    1 => 'nombre',    2 => 'marca',    3 => 'descripcion',    4 => 'producto_categoria_id',    5 => 'producto_udm_id',    6 => 'ubicacion_fisica',  ),  'Archivos Asociados' =>   array(    0 => 'producto_archivo_list',  ),  'Proveedores' =>   array(    0 => 'producto_proveedor_list',  ),  'Control de Stock' =>   array(    0 => '_stock_actual',    1 => '_stock_reservado',    2 => 'stock_preaviso',    3 => 'stock_critico',  ),);
  }

  public function getEditDisplay()
  {
    return array();
  }

  public function getNewDisplay()
  {
    return array();
  }

  public function getListDisplay()
  {
    return array(  0 => 'id',  1 => 'codigo',  2 => 'nombre',  3 => 'stock_actual',  4 => 'ubicacion_fisica',);
  }

  public function getFieldsDefault()
  {
    return array(
      'id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'codigo' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'nombre' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'marca' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'descripcion' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'producto_categoria_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',  'label' => 'Categoría',),
      'producto_udm_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',  'label' => 'Unidad de Medida',),
      'ubicacion_fisica' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Ubicación',),
      'stock_actual' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'stock_reservado' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'stock_preaviso' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'stock_critico' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'producto_proveedor_list' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Proveedores',),
      'producto_archivo_list' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Archivos asociados a este producto',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'id' => array(),
      'codigo' => array(),
      'nombre' => array(),
      'marca' => array(),
      'descripcion' => array(),
      'producto_categoria_id' => array(),
      'producto_udm_id' => array(),
      'ubicacion_fisica' => array(),
      'stock_actual' => array(),
      'stock_reservado' => array(),
      'stock_preaviso' => array(),
      'stock_critico' => array(),
      'producto_proveedor_list' => array(),
      'producto_archivo_list' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'id' => array(),
      'codigo' => array(),
      'nombre' => array(),
      'marca' => array(),
      'descripcion' => array(),
      'producto_categoria_id' => array(),
      'producto_udm_id' => array(),
      'ubicacion_fisica' => array(),
      'stock_actual' => array(),
      'stock_reservado' => array(),
      'stock_preaviso' => array(),
      'stock_critico' => array(),
      'producto_proveedor_list' => array(),
      'producto_archivo_list' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'id' => array(),
      'codigo' => array(),
      'nombre' => array(),
      'marca' => array(),
      'descripcion' => array(),
      'producto_categoria_id' => array(),
      'producto_udm_id' => array(),
      'ubicacion_fisica' => array(),
      'stock_actual' => array(),
      'stock_reservado' => array(),
      'stock_preaviso' => array(),
      'stock_critico' => array(),
      'producto_proveedor_list' => array(),
      'producto_archivo_list' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'id' => array(),
      'codigo' => array(),
      'nombre' => array(),
      'marca' => array(),
      'descripcion' => array(),
      'producto_categoria_id' => array(),
      'producto_udm_id' => array(),
      'ubicacion_fisica' => array(),
      'stock_actual' => array(),
      'stock_reservado' => array(),
      'stock_preaviso' => array(),
      'stock_critico' => array(),
      'producto_proveedor_list' => array(),
      'producto_archivo_list' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'id' => array(),
      'codigo' => array(),
      'nombre' => array(),
      'marca' => array(),
      'descripcion' => array(),
      'producto_categoria_id' => array(),
      'producto_udm_id' => array(),
      'ubicacion_fisica' => array(),
      'stock_actual' => array(),
      'stock_reservado' => array(),
      'stock_preaviso' => array(),
      'stock_critico' => array(),
      'producto_proveedor_list' => array(),
      'producto_archivo_list' => array(),
    );
  }


  public function getForm($object = null)
  {
    $class = $this->getFormClass();

    return new $class($object, $this->getFormOptions());
  }

  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return 'ProductoForm';
  }

  public function getFormOptions()
  {
    return array();
  }

  public function hasFilterForm()
  {
    return true;
  }

  /**
   * Gets the filter form class name
   *
   * @return string The filter form class name associated with this generator
   */
  public function getFilterFormClass()
  {
    return 'ProductoFormFilter';
  }

  public function getFilterForm($filters)
  {
    $class = $this->getFilterFormClass();

    return new $class($filters, $this->getFilterFormOptions());
  }

  public function getFilterFormOptions()
  {
    return array();
  }

  public function getFilterDefaults()
  {
    return array();
  }

  public function getPager($model)
  {
    $class = $this->getPagerClass();

    return new $class($model, $this->getPagerMaxPerPage());
  }

  public function getPagerClass()
  {
    return 'sfPropelPager';
  }

  public function getPagerMaxPerPage()
  {
    return 20;
  }

  public function getDefaultSort()
  {
    return array(null, null);
  }

  public function getPeerMethod()
  {
    return 'doSelect';
  }

  public function getPeerCountMethod()
  {
    return 'doCount';
  }

  public function getConnection()
  {
    return null;
  }
}
