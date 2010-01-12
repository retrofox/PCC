<?php

/**
 * NotaPedido form base class.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseNotaPedidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'numero'                  => new sfWidgetFormInput(),
      'revision'                => new sfWidgetFormInput(),
      'fecha'                   => new sfWidgetFormDate(),
      'fecha_plazo_entrega'     => new sfWidgetFormDate(),
      'proveedor_id'            => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'plazo_entrega'           => new sfWidgetFormInput(),
      'condicion_pago'          => new sfWidgetFormPropelChoice(array('model' => 'FormasDePago', 'add_empty' => true)),
      'condicion_pago_detalle'  => new sfWidgetFormInput(),
      'condicion_lugar_entrega' => new sfWidgetFormInput(),
      'remitir_doc_a'           => new sfWidgetFormInput(),
      'transporte_id'           => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'lugar_entrega'           => new sfWidgetFormInput(),
      'remito_proveedor'        => new sfWidgetFormInputCheckbox(),
      'certificado_calidad'     => new sfWidgetFormInputCheckbox(),
      'factura'                 => new sfWidgetFormInputCheckbox(),
      'manuales'                => new sfWidgetFormInputCheckbox(),
      'ensayos'                 => new sfWidgetFormInputCheckbox(),
      'cert_conformidad'        => new sfWidgetFormInputCheckbox(),
      'MSDS'                    => new sfWidgetFormInputCheckbox(),
      'otros'                   => new sfWidgetFormInputCheckbox(),
      'otros_descripcion'       => new sfWidgetFormInput(),
      'fecha_entrega'           => new sfWidgetFormDate(),
      'administra_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'solicita_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'controla_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'autoriza_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'recepcion_total'         => new sfWidgetFormInputCheckbox(),
      'bloqueada'               => new sfWidgetFormInputCheckbox(),
      'ultima_revision'         => new sfWidgetFormInputCheckbox(),
      'created_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'NotaPedido', 'column' => 'id', 'required' => false)),
      'numero'                  => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'revision'                => new sfValidatorInteger(array('required' => false)),
      'fecha'                   => new sfValidatorDate(array('required' => false)),
      'fecha_plazo_entrega'     => new sfValidatorDate(array('required' => false)),
      'proveedor_id'            => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'plazo_entrega'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'condicion_pago'          => new sfValidatorPropelChoice(array('model' => 'FormasDePago', 'column' => 'id', 'required' => false)),
      'condicion_pago_detalle'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'condicion_lugar_entrega' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'remitir_doc_a'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'transporte_id'           => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'lugar_entrega'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'remito_proveedor'        => new sfValidatorBoolean(array('required' => false)),
      'certificado_calidad'     => new sfValidatorBoolean(array('required' => false)),
      'factura'                 => new sfValidatorBoolean(array('required' => false)),
      'manuales'                => new sfValidatorBoolean(array('required' => false)),
      'ensayos'                 => new sfValidatorBoolean(array('required' => false)),
      'cert_conformidad'        => new sfValidatorBoolean(array('required' => false)),
      'MSDS'                    => new sfValidatorBoolean(array('required' => false)),
      'otros'                   => new sfValidatorBoolean(array('required' => false)),
      'otros_descripcion'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_entrega'           => new sfValidatorDate(array('required' => false)),
      'administra_id'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'solicita_id'             => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'controla_id'             => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'autoriza_id'             => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'recepcion_total'         => new sfValidatorBoolean(array('required' => false)),
      'bloqueada'               => new sfValidatorBoolean(array('required' => false)),
      'ultima_revision'         => new sfValidatorBoolean(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'NotaPedido', 'column' => array('numero', 'revision')))
    );

    $this->widgetSchema->setNameFormat('nota_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaPedido';
  }


}
