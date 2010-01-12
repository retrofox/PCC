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
class sfGuardUserActions extends autoSfGuardUserActions
{
  public function executeListProfile (sfWebRequest $request)
  {
  	// Buscamos id del user en userProfile (user_id) y redireccionamos
  	//$id = $request->getParameter('id');
  	//$user = sfGuardUserPeer::retrieveByPK($request->getParameter('id'));
  	//$this->redirect('sf_guard_user_profile/editWin?id='.$user->getProfile()->getId());
        $this->forward ('sf_guard_user_profile', 'edit');
  }

/*
  public function executeEdit (sfWebRequest $request) {
      if ($request->hasAttribute('user_id')) {

          $this->sf_guard_user = sfGuardUserPeer::retrieveByPK($request->getAttribute('user_id'));
          $this->form = $this->configuration->getForm($this->sf_guard_user);

           // Ajax Request ?
            if ($this->getRequest()->isXmlHttpRequest()) {
            // respuesta JSON
                $arrMeta = array ('win' => array(
                    'module-name' => $this->getModuleName(),
                    'action-name' => 'edit',
                    'sf_method' => 'GET',
                    'sf_id_form' => 'sf_admin_list_form_method-'.$this->getModuleName()
                ));
                $this->json_meta = json_encode($arrMeta);
                $this->setTemplate('editWin');
            }
      }
      else {
          parent::executeEdit($request);
      }
  }
*/
/*
  public function executeListNewAccount (sfWebRequest $request) {
     // Enlace para crear una cuenta de usuario (sfGuardUser)
     $this->forward('sfGuardUser', 'newWin');
  }
*/

}
