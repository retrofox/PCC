<?php

/**
 * Compra para Producto form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class Compra4NotaPedidoForm extends CompraForm {

  public function configure() {
    parent::configure();

    unset (
      $this['fecha'],
      $this['fecha_entrega'],
      $this['proveedor_id'],
      $this['moneda']
    );

    $this->setDefault('is4', 'nota_pedido');
  }
}