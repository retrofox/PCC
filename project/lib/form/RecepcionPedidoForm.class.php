<?php

/**
 * RecepcionPedido form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RecepcionPedidoForm extends BaseRecepcionPedidoForm
{
   public function configure() {
        $this->validatorSchema['nota_pedido_id']->setOption ('required', true);
        $this->validatorSchema['fecha']->setOption ('required', true);
        $this->validatorSchema['recibe_id']->setOption ('required', true);
        $this->validatorSchema['controla_id']->setOption ('required', true);
        $this->validatorSchema['administra_id']->setOption ('required', true);
        $this->validatorSchema['proveedor_factura']->setOption ('required', true);
        $this->validatorSchema['proveedor_remito']->setOption ('required', true);

        $this->widgetSchema['fecha'] = new sfWidgetFormDate(array(
            'format' => '%day% - %month% - %year%',
            'can_be_empty' => false
        ));
        $this->widgetSchema['recibe_id'] = new sfWidgetFormPropelChoice (
            array(
                'model'   =>'sfGuardUserProfile',
                'method'  =>'getApellidoNombre',
                'key_method' => 'getUserId',
                'order_by' => array('Apellido', 'asc'),
                'add_empty' => true
                )
        );
        $this->widgetSchema['administra_id'] = new sfWidgetFormPropelChoice (
            array(
                'model'   =>'sfGuardUserProfile',
                'method'  =>'getApellidoNombre',
                'key_method' => 'getUserId',
                'order_by' => array('Apellido', 'asc'),
                'add_empty' => true
                )
        );
         $this->widgetSchema['controla_id'] = new sfWidgetFormPropelChoice (
            array(
                'model'   =>'sfGuardUserProfile',
                'method'  =>'getApellidoNombre',
                'key_method' => 'getUserId',
                'order_by' => array('Apellido', 'asc'),
                'add_empty' => true
                )
        );
        $this->widgetSchema['transportista_id'] = new sfWidgetFormPropelChoice(array(
            'model' => 'Proveedor',
            'add_empty' => true,
            'peer_method' => 'retrieveTransportistas'
        ));

        $this->widgetSchema['fecha'] = new sfWidgetFormDate(array(
            'format' => '%day% - %month% - %year%'
        ));

        // Valor por defecto
        $this->setDefaults (array(
            'fecha'=> date ('Y-m-d'),
        ));
    }

    
}
