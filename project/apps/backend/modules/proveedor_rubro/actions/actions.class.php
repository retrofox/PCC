<?php

require_once dirname(__FILE__).'/../lib/proveedor_rubroGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/proveedor_rubroGeneratorHelper.class.php';

/**
 * proveedor_rubro actions.
 *
 * @package    pcc
 * @subpackage proveedor_rubro
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class proveedor_rubroActions extends autoProveedor_rubroActions
{
	public function executeListNew (sfWebRequest $request) {
		$this->forward('proveedor_rubro', 'newWin');
	}
	
	public function executeListEdit (sfWebRequest $request) {
		$this->forward('proveedor_rubro', 'editWin');
	}
	
	 public function executeEditWin (sfWebRequest $request) {
		$this->proveedor_rubro = ProveedorRubroPeer::retrieveByPK($request->getParameter('id'));
    	$this->form = $this->configuration->getForm($this->proveedor_rubro);
	}
}
