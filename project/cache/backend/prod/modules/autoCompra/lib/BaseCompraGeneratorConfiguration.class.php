<?php

/**
 * compra module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage compra
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 12831 2008-11-09 14:33:38Z fabien $
 */
class BaseCompraGeneratorConfiguration extends sfModelGeneratorConfiguration
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
    return array(  '_edit' =>   array(    'inWinPopUp' => true,  ),  '_delete' => NULL,);
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
    return '%%fecha%% - %%producto%% - %%proveedor%% - %%cantidad%% - %%ultimo_estado%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'Listado de Compras';
  }

  public function getEditTitle()
  {
    return 'Editar Compra';
  }

  public function getNewTitle()
  {
    return 'Compra de Producto';
  }

  public function getFilterDisplay()
  {
    return array(  0 => 'producto_id',  1 => 'proveedor_id',  2 => 'nota_pedido_id',  3 => 'fecha',);
  }

  public function getFormDisplay()
  {
    return array(  'Compra' =>   array(    0 => 'nota_pedido_id',    1 => 'producto_id',    2 => 'proveedor_id',    3 => 'cantidad',    4 => 'precio',    5 => 'moneda',    6 => 'fecha',    7 => 'fecha_entrega',  ),  'Comentario' =>   array(    0 => 'comentario',  ),);
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
    return array(  0 => 'fecha',  1 => 'producto',  2 => 'proveedor',  3 => 'cantidad',  4 => 'ultimo_estado',);
  }

  public function getFieldsDefault()
  {
    return array(
      'id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'producto_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',  'label' => 'Producto',),
      'cantidad' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'proveedor_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',  'label' => 'Proveedor',),
      'nota_pedido_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',),
      'precio' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'moneda' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'fecha' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',  'label' => 'Fecha',  'date_format' => 'dd/MM/yy',),
      'fecha_entrega' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',  'label' => 'Fecha de Entrega',  'date_format' => 'dd/MM/yy',),
      'comentario' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'created_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'id' => array(),
      'producto_id' => array(),
      'cantidad' => array(  'label' => 'Cant.',),
      'proveedor_id' => array(),
      'nota_pedido_id' => array(  'label' => 'NP',),
      'precio' => array(),
      'moneda' => array(),
      'fecha' => array(),
      'fecha_entrega' => array(),
      'comentario' => array(),
      'created_at' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'id' => array(),
      'producto_id' => array(),
      'cantidad' => array(),
      'proveedor_id' => array(),
      'nota_pedido_id' => array(  'label' => 'Nota de Pedido',),
      'precio' => array(),
      'moneda' => array(),
      'fecha' => array(),
      'fecha_entrega' => array(),
      'comentario' => array(),
      'created_at' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'id' => array(),
      'producto_id' => array(),
      'cantidad' => array(),
      'proveedor_id' => array(),
      'nota_pedido_id' => array(),
      'precio' => array(  'help' => 'precio por unidad',),
      'moneda' => array(),
      'fecha' => array(),
      'fecha_entrega' => array(),
      'comentario' => array(),
      'created_at' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'id' => array(),
      'producto_id' => array(),
      'cantidad' => array(),
      'proveedor_id' => array(),
      'nota_pedido_id' => array(),
      'precio' => array(),
      'moneda' => array(),
      'fecha' => array(),
      'fecha_entrega' => array(),
      'comentario' => array(),
      'created_at' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'id' => array(),
      'producto_id' => array(),
      'cantidad' => array(),
      'proveedor_id' => array(),
      'nota_pedido_id' => array(),
      'precio' => array(),
      'moneda' => array(),
      'fecha' => array(),
      'fecha_entrega' => array(),
      'comentario' => array(),
      'created_at' => array(),
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
    return 'CompraForm';
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
    return 'CompraFormFilter';
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
    return 15;
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
