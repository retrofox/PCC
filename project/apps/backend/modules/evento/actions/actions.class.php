<?php

require_once dirname(__FILE__).'/../lib/eventoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eventoGeneratorHelper.class.php';

/**
 * evento actions.
 *
 * @package    pcc
 * @subpackage evento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class eventoActions extends autoEventoActions {

// Redefinimos metodo executeNewWin
  public function executeNew(sfWebRequest $request) {

    if ($request->hasParameter('id')) {
    $this->setLayout(false);

    // Nuevo objeto instanciado de la clase Evento
    $this->evento = new Evento ();

    // Definimos el id del producto (producto_id) que viene por URL
    $this->evento->setProductoId($request->getParameter('id'));

    // Definimos el id de usuario (user_id) que está logueado en la app.
    $this->evento->setUserId ($this->getUser()->getGuardUser()->getId());

    // Definimos la fecha y hora actual
    $this->evento->setFecha(date('Y-m-d H:i', time()));

    // Definimos un nuevo objeto de formulario
    $this->form = new EventoForm($this->evento);

    $this->setTemplate('newWin');
    }
    else {
      parent::executeNew ($request);
    }
  }
}