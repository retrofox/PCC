<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
	  unset(
	     $this['user_id']//, $this['language']
	  );
  	
  	/*
  	 * Definimos el tipo de documento como un select
  	 */
  	$this->widgetSchema['documento_tipo'] = new sfWidgetFormChoice(array(
      'choices' => sfGuardUserProfilePeer::$dniTipo,
      'expanded' => false
    ));
  	
    
  	$this->validatorSchema['nombre'] =  new sfValidatorString(array('max_length' => 255, 'required' => true));
  	$this->validatorSchema['apellido'] =  new sfValidatorString(array('max_length' => 255, 'required' => true));
  	

  	$this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));

  }
}
