<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * RecepcionPedido filter form base class.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseRecepcionPedidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nota_pedido_id'            => new sfWidgetFormPropelChoice(array('model' => 'NotaPedido', 'add_empty' => true)),
      'fecha'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'recibe_id'                 => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'controla_id'               => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'administra_id'             => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'proveedor_factura'         => new sfWidgetFormFilterInput(),
      'proveedor_remito'          => new sfWidgetFormFilterInput(),
      'transportista_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'transportista_numero_guia' => new sfWidgetFormFilterInput(),
      'transportista_bultos'      => new sfWidgetFormFilterInput(),
      'remito_proveedor'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'certificado_calidad'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'factura'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'manuales'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ensayos'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cert_conformidad'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'MSDS'                      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'otros'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'otros_descripcion'         => new sfWidgetFormFilterInput(),
      'error_envio'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'error_envio_desc'          => new sfWidgetFormFilterInput(),
      'rechazado'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'rechazado_desc'            => new sfWidgetFormFilterInput(),
      'control_items'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'control_precios'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'control_calidad'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'control_cantidad'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cerrada'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nota_pedido_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'NotaPedido', 'column' => 'id')),
      'fecha'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'recibe_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'controla_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'administra_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'proveedor_factura'         => new sfValidatorPass(array('required' => false)),
      'proveedor_remito'          => new sfValidatorPass(array('required' => false)),
      'transportista_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'transportista_numero_guia' => new sfValidatorPass(array('required' => false)),
      'transportista_bultos'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'remito_proveedor'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'certificado_calidad'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'factura'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'manuales'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ensayos'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cert_conformidad'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'MSDS'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'otros'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'otros_descripcion'         => new sfValidatorPass(array('required' => false)),
      'error_envio'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'error_envio_desc'          => new sfValidatorPass(array('required' => false)),
      'rechazado'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'rechazado_desc'            => new sfValidatorPass(array('required' => false)),
      'control_items'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'control_precios'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'control_calidad'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'control_cantidad'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cerrada'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('recepcion_pedido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecepcionPedido';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nota_pedido_id'            => 'ForeignKey',
      'fecha'                     => 'Date',
      'recibe_id'                 => 'ForeignKey',
      'controla_id'               => 'ForeignKey',
      'administra_id'             => 'ForeignKey',
      'proveedor_factura'         => 'Text',
      'proveedor_remito'          => 'Text',
      'transportista_id'          => 'ForeignKey',
      'transportista_numero_guia' => 'Text',
      'transportista_bultos'      => 'Number',
      'remito_proveedor'          => 'Boolean',
      'certificado_calidad'       => 'Boolean',
      'factura'                   => 'Boolean',
      'manuales'                  => 'Boolean',
      'ensayos'                   => 'Boolean',
      'cert_conformidad'          => 'Boolean',
      'MSDS'                      => 'Boolean',
      'otros'                     => 'Boolean',
      'otros_descripcion'         => 'Text',
      'error_envio'               => 'Boolean',
      'error_envio_desc'          => 'Text',
      'rechazado'                 => 'Boolean',
      'rechazado_desc'            => 'Text',
      'control_items'             => 'Boolean',
      'control_precios'           => 'Boolean',
      'control_calidad'           => 'Boolean',
      'control_cantidad'          => 'Boolean',
      'cerrada'                   => 'Boolean',
    );
  }
}
