<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * UserProfile filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'language'          => new sfWidgetFormFilterInput(),
      'nombre'            => new sfWidgetFormFilterInput(),
      'apellido'          => new sfWidgetFormFilterInput(),
      'fdn'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'nacionalidad'      => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'documento_tipo'    => new sfWidgetFormFilterInput(),
      'documento_numero'  => new sfWidgetFormFilterInput(),
      'cuil'              => new sfWidgetFormFilterInput(),
      'legajo'            => new sfWidgetFormFilterInput(),
      'telefono'          => new sfWidgetFormFilterInput(),
      'movil'             => new sfWidgetFormFilterInput(),
      'email'             => new sfWidgetFormFilterInput(),
      'domicilio_calle'   => new sfWidgetFormFilterInput(),
      'domicilio_numero'  => new sfWidgetFormFilterInput(),
      'domicilio_manzana' => new sfWidgetFormFilterInput(),
      'domicilio_barrio'  => new sfWidgetFormFilterInput(),
      'domicilio_piso'    => new sfWidgetFormFilterInput(),
      'domicilio_depto'   => new sfWidgetFormFilterInput(),
      'localidad_id'      => new sfWidgetFormPropelChoice(array('model' => 'Localidad', 'add_empty' => true)),
      'provincia_id'      => new sfWidgetFormPropelChoice(array('model' => 'Provincia', 'add_empty' => true)),
      'comentario'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'language'          => new sfValidatorPass(array('required' => false)),
      'nombre'            => new sfValidatorPass(array('required' => false)),
      'apellido'          => new sfValidatorPass(array('required' => false)),
      'fdn'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'nacionalidad'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pais', 'column' => 'id')),
      'documento_tipo'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'documento_numero'  => new sfValidatorPass(array('required' => false)),
      'cuil'              => new sfValidatorPass(array('required' => false)),
      'legajo'            => new sfValidatorPass(array('required' => false)),
      'telefono'          => new sfValidatorPass(array('required' => false)),
      'movil'             => new sfValidatorPass(array('required' => false)),
      'email'             => new sfValidatorPass(array('required' => false)),
      'domicilio_calle'   => new sfValidatorPass(array('required' => false)),
      'domicilio_numero'  => new sfValidatorPass(array('required' => false)),
      'domicilio_manzana' => new sfValidatorPass(array('required' => false)),
      'domicilio_barrio'  => new sfValidatorPass(array('required' => false)),
      'domicilio_piso'    => new sfValidatorPass(array('required' => false)),
      'domicilio_depto'   => new sfValidatorPass(array('required' => false)),
      'localidad_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Localidad', 'column' => 'id')),
      'provincia_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Provincia', 'column' => 'id')),
      'comentario'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserProfile';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'user_id'           => 'ForeignKey',
      'language'          => 'Text',
      'nombre'            => 'Text',
      'apellido'          => 'Text',
      'fdn'               => 'Date',
      'nacionalidad'      => 'ForeignKey',
      'documento_tipo'    => 'Number',
      'documento_numero'  => 'Text',
      'cuil'              => 'Text',
      'legajo'            => 'Text',
      'telefono'          => 'Text',
      'movil'             => 'Text',
      'email'             => 'Text',
      'domicilio_calle'   => 'Text',
      'domicilio_numero'  => 'Text',
      'domicilio_manzana' => 'Text',
      'domicilio_barrio'  => 'Text',
      'domicilio_piso'    => 'Text',
      'domicilio_depto'   => 'Text',
      'localidad_id'      => 'ForeignKey',
      'provincia_id'      => 'ForeignKey',
      'comentario'        => 'Text',
    );
  }
}
