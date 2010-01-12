<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'language'          => new sfWidgetFormInput(),
      'nombre'            => new sfWidgetFormInput(),
      'apellido'          => new sfWidgetFormInput(),
      'fdn'               => new sfWidgetFormDate(),
      'nacionalidad'      => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'documento_tipo'    => new sfWidgetFormInput(),
      'documento_numero'  => new sfWidgetFormInput(),
      'cuil'              => new sfWidgetFormInput(),
      'legajo'            => new sfWidgetFormInput(),
      'telefono'          => new sfWidgetFormInput(),
      'movil'             => new sfWidgetFormInput(),
      'email'             => new sfWidgetFormInput(),
      'domicilio_calle'   => new sfWidgetFormInput(),
      'domicilio_numero'  => new sfWidgetFormInput(),
      'domicilio_manzana' => new sfWidgetFormInput(),
      'domicilio_barrio'  => new sfWidgetFormInput(),
      'domicilio_piso'    => new sfWidgetFormInput(),
      'domicilio_depto'   => new sfWidgetFormInput(),
      'localidad_id'      => new sfWidgetFormPropelChoice(array('model' => 'Localidad', 'add_empty' => true)),
      'provincia_id'      => new sfWidgetFormPropelChoice(array('model' => 'Provincia', 'add_empty' => true)),
      'comentario'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'user_id'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'language'          => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'nombre'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'apellido'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fdn'               => new sfValidatorDate(array('required' => false)),
      'nacionalidad'      => new sfValidatorPropelChoice(array('model' => 'Pais', 'column' => 'id', 'required' => false)),
      'documento_tipo'    => new sfValidatorInteger(array('required' => false)),
      'documento_numero'  => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'cuil'              => new sfValidatorString(array('max_length' => 13, 'required' => false)),
      'legajo'            => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'telefono'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'movil'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'domicilio_calle'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'domicilio_numero'  => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'domicilio_manzana' => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'domicilio_barrio'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'domicilio_piso'    => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'domicilio_depto'   => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'localidad_id'      => new sfValidatorPropelChoice(array('model' => 'Localidad', 'column' => 'id', 'required' => false)),
      'provincia_id'      => new sfValidatorPropelChoice(array('model' => 'Provincia', 'column' => 'id', 'required' => false)),
      'comentario'        => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


}
