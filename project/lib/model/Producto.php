<?php

class Producto extends BaseProducto {
/**
 * Devuelve nombre del producto gracias al metodo magico __toString() mediante el metodo $this->getNombre()
 *
 * @return string nombre del producto
 */
  public function __toString () {
    return $this->getNombre();
  }

  public function recalcNow() {
  // Calculamos la cantidad por eventos. Sumamos o Restamos la cantidad en funcopn del decremento/incremento.
    $eventos = $this->getEventos();
    $qttEvento = 0;
    foreach ($eventos as $evento) {
      if ($evento->getCantidad()) {
        $qttEvento = ($evento->getOperacion()) ? ($qttEvento + $evento->getCantidad()) : ($qttEvento -$evento->getCantidad());
      }
    }

    // Calculamos la cantidad de las compras
    $this->setStockActual ($qttEvento);
    $this->save();
  }
  public function recalcStock() {
    $stock4Compras = ProductoPeer::recalcStock4Compras($this->getId());
    $stock4Eventos = ProductoPeer::recalcStock4Eventos($this->getId());
    $stock4Ventas = ProductoPeer::recalcStock4Ventas($this->getId());
    $stock=$stock4Compras+$stock4Eventos-$stock4Ventas;
    $this->setStockActual ($stock);
    $this->save();
  }
     /*
     * Este metodo nos devuelve las compras finalizadas. Para esto es importante destacar los estados:
     * 4 - Realizada
     * 6 - Entrega Parcial (ojo, ver ...)
     * 7 - Compra Inmediata
     */
  public function getComprasFinalizadas () {
    $c = new Criteria ();
    $c1 = $c->getNewCriterion(CompraEstadoPeer::ESTADO_ID,7);
    $c2 = $c->getNewCriterion(CompraEstadoPeer::ESTADO_ID,6);
    $c3 = $c->getNewCriterion(CompraEstadoPeer::ESTADO_ID,4);
    $c1->addOr($c2);
    $c1->addOr($c3);
    $c->add($c1);
    $c->add(CompraPeer::PRODUCTO_ID,$this->getId());
    $c->addAscendingOrderByColumn(CompraEstadoPeer::FECHA);
    $c->addJoin(CompraPeer::ID, CompraEstadoPeer::COMPRA_ID);
    $comprasFin=CompraPeer::doSelect($c);
    return $comprasFin;
  }
  public function getVentasFinalizadas () {
    $c = new Criteria ();
    $c1 = $c->getNewCriterion(VentaEstadoPeer::ESTADO_ID,9);
    $c2 = $c->getNewCriterion(VentaEstadoPeer::ESTADO_ID,13);
    $c1->addOr($c2);
    $c->add($c1);
    $c->add(VentaPeer::PRODUCTO_ID,$this->getId());
    $c->addAscendingOrderByColumn(VentaEstadoPeer::FECHA);
    $c->addJoin(VentaPeer::ID, VentaEstadoPeer::VENTA_ID);
    $comprasFin=VentaPeer::doSelect($c);
    return $comprasFin;
  }

  public function incrementarStock($cantidad) {
    ProductoPeer::actualizarStock($this->getId(), $cantidad, true);
    return $this->getStockActual();
  }

  public function decrementarStock($cantidad) {
    ProductoPeer::actualizarStock($this->getId(), $cantidad, false);
    return $this->getStockActual();
  }
}
