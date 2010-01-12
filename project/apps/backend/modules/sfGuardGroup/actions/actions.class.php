<?php

//require_once dirname(__FILE__).'/../lib/sf_guard_user_profileGeneratorConfiguration.class.php';
//require_once dirname(__FILE__).'/../lib/sf_guard_user_profileGeneratorHelper.class.php';

/**
 * sf_guard_user_profile actions.
 *
 * @package    pcc
 * @subpackage sf_guard_user_profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class sfGuardGroupActions extends autoSfGuardGroupActions
{
	public function executeListEdit (sfWebRequest $request) {
		$this->forward('sfGuardGroup', 'editWin');
	}

	public function executeEditWin (sfWebRequest $request) {
		$this->sf_guard_group = sfGuardGroupPeer::retrieveByPK($request->getParameter('id'));
    	$this->form = $this->configuration->getForm($this->sf_guard_group);
    	//die ('$request->getParameter(id): '.$request->getParameter('id'));    	
	}

	public function executeListNew (sfWebRequest $request) {
		// Enlace para crear una cuenta de usuario (sfGuardUser)
		$this->forward('sfGuardGroup', 'newWin');
	}
}
