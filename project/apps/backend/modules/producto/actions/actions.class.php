<?php

require_once dirname(__FILE__).'/../lib/productoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoGeneratorHelper.class.php';

/**
 * producto actions.
 *
 * @package    pcc
 * @subpackage producto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class productoActions extends autoProductoActions {

// Comportamiento para agregar UDM al producto
  public function executeCreateUDM (sfWebRequest $request) {
    $this->select2Add = new ProductoUDM();
    $this->select2Add->setNombre($request->getParameter('value'));
    $this->select2Add->save();

    $this->options = ProductoUDMPeer::doSelect(new Criteria());

    return $this->renderPartial('global/selectUpdated');
  }

  // Comportamiento para agregar una Categoria
  public function executeCreateCategoria (sfWebRequest $request) {
    $this->select2Add = new ProductoCategoria();
    $this->select2Add->setNombre($request->getParameter('value'));
    $this->select2Add->save();

    $this->options = ProductoCategoriaPeer::doSelect(new Criteria());

    return $this->renderPartial('global/selectUpdated');
  }

  public function executeListEvento (sfWebRequest $request) {
    $this->forward('evento', 'new');
  }

  public function executeListComprar (sfWebRequest $request) {
    $this->getRequest()->setParameter ('producto_id', $this->getRequest()->getParameter('id'));
    $this->forward('compra', 'new');
  }


  public function executeListVenta (sfWebRequest $request) {
    $this->getRequest()->setParameter ('producto_id', $this->getRequest()->getParameter('id'));
    $this->forward('venta', 'new');
  }


  /*
   * Stock de Producto - Recalc
   */
  public function executeListRecalc (sfWebRequest $request) {
    $this->forward('producto', 'recalc');
  }

  public function executeListRecalcContent (sfWebRequest $request) {
    $this->forward('producto', 'recalcContent');
  }



  public function executeRecalc (sfWebRequest $request) {
    if ($request->getParameter ('recalcNow')) {
      $this->producto = ProductoPeer::retrieveByPK($request->getParameter('id'));
      $this->producto->recalcStock();

      return $this->renderPartial('producto/recalcComplete');
    }
    else {

    // Variables Estaticas
    $this->win = array (
      'nodeId_formMethod'=> 'sf_admin_list_form_method-producto',
      'nodeId_container' => 'sf_admin_container-index-producto',
      'nodeId_winsEmbedded'=> 'embedded_win-producto',
      'obj_parent' => 'this'
    );

    $this->controller = array (
      'moduleName' => 'producto',
      'action' => 'recalc'
    );

    $this->dims = array (
      'width' => 800,
      'left' => 100,
      'top' => 40
    );

      $this->producto = ProductoPeer::retrieveByPK($request->getParameter('id'));
      $this->formu = new RecalcNowForm(array('recalcNow'=> true, 'id'=>$request->getParameter('id')));
    }
  }

  public function executeRecalcContent (sfWebRequest $request) {
    $this->producto = ProductoPeer::retrieveByPK($request->getParameter('id'));
    $this->formu = new RecalcNowForm(array('recalcNow'=> true, 'id'=>$request->getParameter('id')));
  }
}