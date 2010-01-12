<?php
class sfGuardPermissionActions extends autoSfGuardPermissionActions
{
	public function executeListNew () {
		// Enlace para crear una cuenta de usuario (sfGuardUser)
		$this->forward('sfGuardPermission', 'newWin');
	}
	
	public function executeListEdit (sfWebRequest $request) {
		$this->forward('sfGuardPermission', 'editWin');
	}

	public function executeEditWin (sfWebRequest $request) {
		$this->sf_guard_permission = sfGuardPermissionPeer::retrieveByPK($request->getParameter('id'));
    	$this->form = $this->configuration->getForm($this->sf_guard_permission);
    	//die ('$request->getParameter(id): '.$request->getParameter('id'));    	
	}
}