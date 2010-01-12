<?php

/**
 * default actions.
 *
 * @package    pcc
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class defaultActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
  }
  
  public function executeError404() {
	return '';
  }
  
  	/**
  	 * Ejemplo de prueba de un envio de datos a traves de un formulario con AJAX
  	 *
  	 * @author retrofox
  	 * @date 24/01/2009
  	 *
  	 * @params parametro_tipo (parametro_valor) parametro_nombre parametro_descripcion
  	 * @return retorna_tipo retorna_descripcion
  	 */
  	public function executeAjaxForm01 (sfWebRequest $request) {
  		// Vamos construir un objeto tipo sf_guard_user_profile
    	$this->formu = new sfGuardUserProfileForm();
  	}
}
