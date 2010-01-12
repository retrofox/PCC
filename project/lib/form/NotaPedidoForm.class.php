<?php

/**
 * NotaPedido form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class NotaPedidoForm extends BaseNotaPedidoForm
{
    public function configure() {
        $this->validatorSchema['numero']->setOption ('required', true);
        $this->validatorSchema['revision']->setOption ('required', true);
        $this->validatorSchema['fecha']->setOption ('required', true);
        $this->validatorSchema['proveedor_id']->setOption ('required', true);

        $this->validatorSchema['plazo_entrega'] = new sfValidatorInteger(array(
                'required' => true,
                'min' => 1,
                'max' => 365
            ));

        $this->validatorSchema['condicion_pago']->setOption ('required', true);
        $this->validatorSchema['condicion_lugar_entrega']->setOption ('required', true);

        $this->widgetSchema['fecha'] = new sfWidgetFormDate(array(
            'format' => '%day% - %month% - %year%',
            'can_be_empty' => false
        ));
        $this->widgetSchema['transporte_id'] = new sfWidgetFormPropelChoice(array(
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

    public function doSave ($con = null) {

    	// Redefinimos el metodo crear de la compra.
    	// Al crear una compra automaticamente generamos el estado inicial.
    	if ($this->isNew()) {
    		$formu_nota_pedido = parent::doSave ($con);

    		// Objeto compra recien agregado
    		$objNotaPedido = $this->getObject();

    		// Nuevo objeto de estado de compra CompraEstado
    		$NotaPedidoEstado = new NotaPedidoEstado();

            // singleton
            $singleton = sfContext::getInstance();

    		$NotaPedidoEstado->setNotaPedidoId($objNotaPedido->getId());
    		$NotaPedidoEstado->setEstadoId(14);					// <- Estado inicial
    		$NotaPedidoEstado->setFecha ($objNotaPedido->getFecha());
            $NotaPedidoEstado->setUserId($singleton->getUser()->getGuardUser()->getId());
    		$NotaPedidoEstado->setObservaciones ('Alta inicial de Nota de Pedido.');
    		

    		// Grabamos estado
    		$NotaPedidoEstado->save();

    		return $formu_nota_pedido;
    	}
    	else {
    		return parent::doSave ($con);
    	};
    }
}
