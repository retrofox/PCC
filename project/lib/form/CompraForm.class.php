<?php

/**
 * Compra form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CompraForm extends BaseCompraForm {

  public function configure() {

    unset(
        $this['created_at']
    );

    $this->validatorSchema['cantidad']->setOption ('required', true);
    $this->validatorSchema['proveedor_id']->setOption ('required', true);
    $this->validatorSchema['producto_id']->setOption ('required', true);
    $this->validatorSchema['precio']->setOption ('required', true);

    $this->widgetSchema['moneda'] = new sfWidgetFormChoice (array(
        'choices' => CompraPeer::$monedas,
        'expanded' => false,
        'multiple' => false
    ));

    $this->widgetSchema['nota_pedido_id'] = new sfWidgetFormInputHidden ();

    $this->widgetSchema['fecha'] = new sfWidgetFormDate(array(
        'format' => '%day% - %month% - %year%',
        'can_be_empty' => false
    ));

    $this->widgetSchema['fecha_entrega'] = new sfWidgetFormDate(array(
        'format' => '%day% - %month% - %year%'
    ));

    // con 'is4' definimos si es para una compra normal, compra a traves de producto, o compra a traves de nota de pedido.
    $this->widgetSchema['is4'] = new sfWidgetFormInputHidden ();
    $this->validatorSchema['is4'] = new sfValidatorString(array('required' => false));

    // Valor por defecto
    $this->setDefaults (array(
        'fecha'=> date ('Y-m-d'),
        'fecha_entrega'=> date ('Y-m-d'),
        'is4Producto' => 'false'
    ));
  }



  public function doSave ($con = null) {

  // Redefinimos el metodo crear de la compra.
  // Al crear una compra automaticamente generamos el estado inicial.
    if ($this->isNew()) {
      $formu_compra = parent::doSave ($con);

      // Objeto compra recien agregado
      $objCompra = $this->getObject();

      // Nuevo objeto de estado de compra CompraEstado
      $compraEstado = new CompraEstado();

      // singleton
      $singleton = sfContext::getInstance();

      $compraEstado->setCompraId($objCompra->getId());
      $compraEstado->setEstadoId(1);					// <- Estado de compra inmediata

      $compraEstado->setCantidad ($objCompra->getCantidad());
      $compraEstado->setFecha ($objCompra->getFecha());
      $compraEstado->setUserId($singleton->getUser()->getGuardUser()->getId());
      $compraEstado->setObservaciones ('Carga inicial.');
      $compraEstado->setNotaRecepcionId(null);

      // Grabamos estado
      $compraEstado->save();

      return $formu_compra;
    }
    else {
      return parent::doSave ($con);
    };
  }
}