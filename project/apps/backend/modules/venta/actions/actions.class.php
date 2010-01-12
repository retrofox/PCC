<?php

require_once dirname(__FILE__).'/../lib/ventaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ventaGeneratorHelper.class.php';

/**
 * venta actions.
 *
 * @package    pcc
 * @subpackage venta
 * @author     Laura Melo
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ventaActions extends autoVentaActions {

  public function executeNew (sfWebRequest $request) {
    if ($this->getRequest()->hasParameter('producto_id') or $this->getRequest()->hasParameter('venta[producto_id]')) {
      $this->setLayout(false);

      // Creamos objeto Venta.
      $this->venta = new Venta ();

      // Seteamos propiedad de producto del nuevo objeto compra.
      $this->venta->setProductoId($this->getRequest()->getParameter('producto_id', $this->getRequest()->hasParameter('venta[producto_id]')));
      
      $this->form = new Venta4ProductoForm ($this->venta);
      $this->getUser()->setFlash('titulo', 'Venta del producto \''.$this->form->getObject()->getProducto().'\'');
      $this->setTemplate('newWin');
    }
    else {
      $this->getUser()->setFlash('titulo', 'Nueva Venta');
      parent::executeNew($request);
    };
  }

  public function executeCreate(sfWebRequest $request)
  {
    if ($this->getRequest()->hasParameter('venta[is4Producto]') and $this->getRequest()->getParameter('venta[is4Producto]') == 'true') {
      $this->form = $this->configuration->get4ProductoForm();
    }
    else {
      $this->form = $this->configuration->getForm();
    }

    $this->venta = $this->form->getObject();
    $this->processForm($request, $this->form);

    if ($this->getRequest()->isXmlHttpRequest()) $this->setTemplate('newWinContent');
  }
  


  protected function processForm(sfWebRequest $request, sfForm $form) {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {

      $this->getUser()->setFlash('notice-venta-edit', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $venta = $form->save();

      if ($this->getRequest()->hasParameter('venta[is4Producto]') and $this->getRequest()->getParameter('venta[is4Producto]') == 'true') {
      // Nuevo objeto de estado de venta ventaEstado
        $ventaEstado = new VentaEstado();
        $ventaEstado->setVentaId($venta->getId());
        $ventaEstado->setEstadoId(9);
        $ventaEstado->setFecha ($venta->getFecha());
        $ventaEstado->setUserId($this->getUser()->getGuardUser()->getId());
        $ventaEstado->setObservaciones ('Venta directa concluida.');
        $ventaEstado->save();
      }


      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $venta)));

      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest()) {
          $this->redirect('venta/newWin');
        }
        else $this->redirect('@venta_new');
      }
      else {
        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          // Redireccionamos a la accion edit.
          $this->redirect('@venta_edit?id='.$venta->getId().'&isCommingEdit=true');
        }
        else $this->redirect('@venta_edit?id='.$venta->getId());
      }
    }
    else {
      $this->getUser()->setFlash('error-venta-edit', 'The item has not been saved due to some errors.');
    }
  }
}