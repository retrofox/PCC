<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * NotaPedido filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseNotaPedidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'numero'                  => new sfWidgetFormFilterInput(),
      'revision'                => new sfWidgetFormFilterInput(),
      'fecha'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'fecha_plazo_entrega'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'proveedor_id'            => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'plazo_entrega'           => new sfWidgetFormFilterInput(),
      'condicion_pago'          => new sfWidgetFormPropelChoice(array('model' => 'FormasDePago', 'add_empty' => true)),
      'condicion_pago_detalle'  => new sfWidgetFormFilterInput(),
      'condicion_lugar_entrega' => new sfWidgetFormFilterInput(),
      'remitir_doc_a'           => new sfWidgetFormFilterInput(),
      'transporte_id'           => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'lugar_entrega'           => new sfWidgetFormFilterInput(),
      'remito_proveedor'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'certificado_calidad'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'factura'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'manuales'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ensayos'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cert_conformidad'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'MSDS'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'otros'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'otros_descripcion'       => new sfWidgetFormFilterInput(),
      'fecha_entrega'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'administra_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'solicita_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'controla_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'autoriza_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'recepcion_total'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'bloqueada'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ultima_revision'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'numero'                  => new sfValidatorPass(array('required' => false)),
      'revision'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_plazo_entrega'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'proveedor_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'plazo_entrega'           => new sfValidatorPass(array('required' => false)),
      'condicion_pago'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'FormasDePago', 'column' => 'id')),
      'condicion_pago_detalle'  => new sfValidatorPass(array('required' => false)),
      'condicion_lugar_entrega' => new sfValidatorPass(array('required' => false)),
      'remitir_doc_a'           => new sfValidatorPass(array('required' => false)),
      'transporte_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'lugar_entrega'           => new sfValidatorPass(array('required' => false)),
      'remito_proveedor'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'certificado_calidad'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'factura'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'manuales'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ensayos'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cert_conformidad'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'MSDS'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'otros'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'otros_descripcion'       => new sfValidatorPass(array('required' => false)),
      'fecha_entrega'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'administra_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'solicita_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'controla_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'autoriza_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'recepcion_total'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'bloqueada'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ultima_revision'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('nota_pedido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaPedido';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'numero'                  => 'Text',
      'revision'                => 'Number',
      'fecha'                   => 'Date',
      'fecha_plazo_entrega'     => 'Date',
      'proveedor_id'            => 'ForeignKey',
      'plazo_entrega'           => 'Text',
      'condicion_pago'          => 'ForeignKey',
      'condicion_pago_detalle'  => 'Text',
      'condicion_lugar_entrega' => 'Text',
      'remitir_doc_a'           => 'Text',
      'transporte_id'           => 'ForeignKey',
      'lugar_entrega'           => 'Text',
      'remito_proveedor'        => 'Boolean',
      'certificado_calidad'     => 'Boolean',
      'factura'                 => 'Boolean',
      'manuales'                => 'Boolean',
      'ensayos'                 => 'Boolean',
      'cert_conformidad'        => 'Boolean',
      'MSDS'                    => 'Boolean',
      'otros'                   => 'Boolean',
      'otros_descripcion'       => 'Text',
      'fecha_entrega'           => 'Date',
      'administra_id'           => 'ForeignKey',
      'solicita_id'             => 'ForeignKey',
      'controla_id'             => 'ForeignKey',
      'autoriza_id'             => 'ForeignKey',
      'recepcion_total'         => 'Boolean',
      'bloqueada'               => 'Boolean',
      'ultima_revision'         => 'Boolean',
      'created_at'              => 'Date',
    );
  }
}
