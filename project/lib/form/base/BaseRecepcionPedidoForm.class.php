<?php

/**
 * RecepcionPedido form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseRecepcionPedidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nota_pedido_id'            => new sfWidgetFormPropelChoice(array('model' => 'NotaPedido', 'add_empty' => true)),
      'fecha'                     => new sfWidgetFormDate(),
      'recibe_id'                 => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'controla_id'               => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'administra_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'proveedor_factura'         => new sfWidgetFormInput(),
      'proveedor_remito'          => new sfWidgetFormInput(),
      'transportista_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'transportista_numero_guia' => new sfWidgetFormInput(),
      'transportista_bultos'      => new sfWidgetFormInput(),
      'remito_proveedor'          => new sfWidgetFormInputCheckbox(),
      'certificado_calidad'       => new sfWidgetFormInputCheckbox(),
      'factura'                   => new sfWidgetFormInputCheckbox(),
      'manuales'                  => new sfWidgetFormInputCheckbox(),
      'ensayos'                   => new sfWidgetFormInputCheckbox(),
      'cert_conformidad'          => new sfWidgetFormInputCheckbox(),
      'MSDS'                      => new sfWidgetFormInputCheckbox(),
      'otros'                     => new sfWidgetFormInputCheckbox(),
      'otros_descripcion'         => new sfWidgetFormInput(),
      'error_envio'               => new sfWidgetFormInputCheckbox(),
      'error_envio_desc'          => new sfWidgetFormInput(),
      'rechazado'                 => new sfWidgetFormInputCheckbox(),
      'rechazado_desc'            => new sfWidgetFormInput(),
      'control_items'             => new sfWidgetFormInputCheckbox(),
      'control_precios'           => new sfWidgetFormInputCheckbox(),
      'control_calidad'           => new sfWidgetFormInputCheckbox(),
      'control_cantidad'          => new sfWidgetFormInputCheckbox(),
      'cerrada'                   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'RecepcionPedido', 'column' => 'id', 'required' => false)),
      'nota_pedido_id'            => new sfValidatorPropelChoice(array('model' => 'NotaPedido', 'column' => 'id', 'required' => false)),
      'fecha'                     => new sfValidatorDate(array('required' => false)),
      'recibe_id'                 => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'controla_id'               => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'administra_id'             => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'proveedor_factura'         => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'proveedor_remito'          => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'transportista_id'          => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'transportista_numero_guia' => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'transportista_bultos'      => new sfValidatorInteger(array('required' => false)),
      'remito_proveedor'          => new sfValidatorBoolean(array('required' => false)),
      'certificado_calidad'       => new sfValidatorBoolean(array('required' => false)),
      'factura'                   => new sfValidatorBoolean(array('required' => false)),
      'manuales'                  => new sfValidatorBoolean(array('required' => false)),
      'ensayos'                   => new sfValidatorBoolean(array('required' => false)),
      'cert_conformidad'          => new sfValidatorBoolean(array('required' => false)),
      'MSDS'                      => new sfValidatorBoolean(array('required' => false)),
      'otros'                     => new sfValidatorBoolean(array('required' => false)),
      'otros_descripcion'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'error_envio'               => new sfValidatorBoolean(array('required' => false)),
      'error_envio_desc'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'rechazado'                 => new sfValidatorBoolean(array('required' => false)),
      'rechazado_desc'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'control_items'             => new sfValidatorBoolean(array('required' => false)),
      'control_precios'           => new sfValidatorBoolean(array('required' => false)),
      'control_calidad'           => new sfValidatorBoolean(array('required' => false)),
      'control_cantidad'          => new sfValidatorBoolean(array('required' => false)),
      'cerrada'                   => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recepcion_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecepcionPedido';
  }


}
