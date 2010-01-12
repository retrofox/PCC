<?php

require_once dirname(__FILE__).'/../lib/compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/compraGeneratorHelper.class.php';

/**
 * compra actions.
 *
 * @package    pcc
 * @subpackage compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class compraActions extends autoCompraActions {

  public function executeNew (sfWebRequest $request) {

  // Creamos nuevo objeto de compra.
    $this->compra = new Compra;

    // Compra inmediata
    // Analizamos si la compra viene solicitada por el el modulo de producto.
    if ($this->getRequest()->hasParameter('producto_id')) {
      $this->setLayout(false);

      // Seteamos propiedades de compra.
      $this->compra->setProductoId($this->getRequest()->getParameter('producto_id', $this->getRequest()->hasParameter('compra[producto_id]')));

      // Creamos objeto de formulario en funcion del objeto compra previamente creado
      $this->form = new Compra4ProductoForm ($this->compra);

      $this->getUser()->setFlash('titulo', 'Compra del producto \''.$this->form->getObject()->getProducto().'\'');
      $this->setTemplate('newWin');
    }
    // Compra en una Nota de Pedido
    // Compra agregada a través de una nota de pedido
    else if ($this->getRequest()->hasParameter('nota_pedido_id')) {
        $id_np = $this->getRequest()->getParameter('nota_pedido_id');

        // Seteamos en la compra el id de la nota de pedido
        $this->compra->setNotaPedidoId($id_np);

        $this->form = new Compra4NotaPedidoForm ($this->compra);

        $this->getUser()->setFlash('titulo', 'Agregar compra a Nota de Pedido.');
        $this->setTemplate('newWin');
      }
      else {
        $this->getUser()->setFlash('titulo', 'Nueva Compra de Producto');
        parent::executeNew($request);
    };
  }


  public function executeCreate(sfWebRequest $request) {
    if ($this->getRequest()->hasParameter('compra[is4]') and $this->getRequest()->getParameter('compra[is4]') == 'producto') {
      $this->form = $this->configuration->get4ProductoForm();
    }
    else if ($this->getRequest()->getParameter('compra[is4]') == 'nota_pedido') {
        $compra = new Compra();
        $nota_de_pedido = NotaPedidoPeer::retrieveByPK($this->getRequest()->getParameter('compra[nota_pedido_id]'));
        $compra->setProveedorId($nota_de_pedido->getProveedorId());
        $compra->setFecha($nota_de_pedido->getFecha());
        $compra->setFechaEntrega($nota_de_pedido->getFechaPlazoEntrega());

        $this->form = new Compra4NotaPedidoForm($compra);
      }
      else {
        $this->form = $this->configuration->getForm();
      }

    $this->compra = $this->form->getObject();
    $this->processForm($request, $this->form);

    if ($this->getRequest()->isXmlHttpRequest()) $this->setTemplate('newWinContent');
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $this->getUser()->setFlash('notice-compra-edit', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $compra = $form->save();                // <- Objeto $compra recien agregado

      if ($this->getRequest()->hasParameter('compra[is4]') and $this->getRequest()->getParameter('compra[is4]') == 'producto') {
        $this->getUser()->getAttributeHolder()->remove('compra_directa');

        $compraEstado = new CompraEstado();
        $compraEstado->setCompraId($compra->getId());
        $compraEstado->setEstadoId(7);					// <- Estado de compra inmediata
        $compraEstado->setCantidad ($compra->getCantidad());
        $compraEstado->setFecha ($compra->getFecha());
        $compraEstado->setUserId($this->getUser()->getGuardUser()->getId());
        $compraEstado->setObservaciones ('Compra directa concluida.');
        $compraEstado->setNotaRecepcionId(null);
        $compraEstado->save();
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $compra)));

      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest()) {
          $this->redirect('compra/newWin');
        }
        else $this->redirect('@compra_new');
      }
      else {
      // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest()) {
          $this->redirect('compra/editWinContent?id='.$compra->getId());
        }
        else $this->redirect('@compra_edit?id='.$compra->getId());
      }
    }
    else {
      $this->getUser()->setFlash('error-compra-edit', 'The item has not been saved due to some errors.');
    }
  }
}