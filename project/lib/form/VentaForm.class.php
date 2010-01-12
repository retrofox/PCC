<?php

/**
 * Venta form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class VentaForm extends BaseVentaForm {
  public function configure() {
    $this->validatorSchema['cantidad']->setOption ('required', true);
    $this->validatorSchema['transportista_interno_id']->setOption ('required', true);
    $this->validatorSchema['transportista_externo_id']->setOption ('required', true);
    $this->validatorSchema['producto_id']->setOption ('required', true);
    $this->validatorSchema['numero_remito']->setOption ('required', true);

    $this->widgetSchema['transportista_interno_id'] = new sfWidgetFormPropelChoice (
        array(
        'model'   =>'sfGuardUserProfile',
        'method'  =>'getApellidoNombre',
        'key_method' => 'getUserId',
        'order_by' => array('Apellido', 'asc'),
        'add_empty' => true
        )
    );
    $this->widgetSchema['transportista_externo_id'] = new sfWidgetFormPropelChoice(array(
        'model' => 'Proveedor',
        'add_empty' => true,
        'peer_method' => 'retrieveTransportistas'
    ));

    $this->widgetSchema['fecha'] = new sfWidgetFormDate(array(
        'format' => '%day% - %month% - %year%',
        'can_be_empty' => false
    ));

    $this->widgetSchema['is4Producto'] = new sfWidgetFormInputHidden ();
    $this->validatorSchema['is4Producto'] = new sfValidatorString(array('required' => false));

    // Valor por defecto
    $this->setDefaults (array(
        'fecha'=> date ('Y-m-d'),
        'is4Producto' => 'false'
    ));
  }

  public function doSave ($con = null) {
  // Redefinimos el metodo crear de la compra.
  // Al crear una compra automaticamente generamos el estado inicial
    if ($this->isNew()) {
      $formu_venta = parent::doSave ($con);

      // Objeto compra recien agregado
      $objVenta = $this->getObject();

      // Nuevo objeto de estado de compra CompraEstado
      $ventaEstado = new VentaEstado();

      // singleton
      $singleton = sfContext::getInstance();

      $ventaEstado->setVentaId($objVenta->getId());
      $ventaEstado->setEstadoId(8);
      $ventaEstado->setFecha ($objVenta->getFecha());
      $ventaEstado->setUserId($singleton->getUser()->getGuardUser()->getId());
      $ventaEstado->setObservaciones ('Carga inicial.');

      // Grabamos estado
      $ventaEstado->save();

      return $formu_venta;
    }
    else {
      return parent::doSave ($con);
    };
  }
}
