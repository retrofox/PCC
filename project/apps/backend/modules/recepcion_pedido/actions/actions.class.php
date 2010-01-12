<?php

require_once dirname(__FILE__).'/../lib/recepcion_pedidoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/recepcion_pedidoGeneratorHelper.class.php';

/**
 * recepcion_pedido actions.
 *
 * @package    pcc
 * @subpackage recepcion_pedido
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class recepcion_pedidoActions extends autoRecepcion_pedidoActions
{
    public function executeListNew (sfWebRequest $request) {
        $this->forward('recepcion_pedido', 'newWin');
    }

    public function executeListEdit (sfWebRequest $request) {
        $this->forward('recepcion_pedido', 'editWin');
    }

    public function executeEditWin (sfWebRequest $request) {
        $this->recepcion_pedido = RecpcionPedidoPeer::retrieveByPK($request->getParameter('id'));
        $this->form = $this->configuration->getForm($this->recepcion_pedido);
    }


}
