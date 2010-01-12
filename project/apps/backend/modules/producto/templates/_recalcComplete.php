<div class="textWin-01">
  <h4><?php echo $producto->getNombre() ?></h4>
  <p class="ok">El Stock del Producto ha sido actualizado al valor <b><?php echo $producto->getStockActual() ?></b>.</p>
</div>


<div class="winAccordion">
  <h2 class="titleSection">Eventos (<?php echo count($producto->getEventos()) ?>)</h2>
  <div class="fieldSection">
    <fieldset>
      <?php if (count($producto->getEventos())) : ?>
      <table class="tabla100">
        <thead>
          <tr>
            <th>id</th>
            <th>Fecha</th>
            <th>C.</th>
            <th>+/-</th>
          </tr>
        </thead>
        <tbody>
            <?php $qttEvento = 0; ?>
            <?php foreach ($producto->getEventos() as $evento) : ?>
          <tr>
            <td><?php echo $evento->getId() ?></td>
            <td><?php echo $evento->getFecha() ?></td>
            <td><?php echo $evento->getCantidad() ?></td>
            <td><?php echo ($evento->getOperacion()) ? '+' : '-' ?></td>
          </tr>

              <?php
              if ($evento->getCantidad()) {
                $qttEvento = ($evento->getOperacion()) ? ($qttEvento + $evento->getCantidad()) : ($qttEvento -$evento->getCantidad());
              }
              ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="2">parcial</th>
            <th colspan="2"><?php echo $qttEvento ?></th>
          </tr>
        </tfoot>
      </table>
      <?php else : ?>
      <p>No existen eventos para este producto.</p>
      <?php endif; ?>
    </fieldset>
  </div>
</div>

<div class="winAccordion">
  <h2 class="titleSection">Entregas por compras (<?php echo count($producto->getComprasFinalizadas()) ?>)</h2>
  <div class="fieldSection">
    <fieldset>
      <?php if (count($producto->getComprasFinalizadas())) : ?>
      <table class="tabla100">
        <thead>
          <tr>
            <th>id</th>
            <th>Fecha</th>
            <th>Cant.</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            <?php $qttCompra = 0; ?>
            <?php foreach ($producto->getComprasFinalizadas() as $compra): ?>
          <tr>
            <td><?php echo $compra->getId() ?></td>
            <td><?php echo $compra->getFecha() ?></td>
            <td><?php echo $compra->getCantidad() ?></td>
            <td></td>
          </tr>
              <?php
              $qttCompra = $compra->getCantidad() + $qttCompra;
              ?>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
          <tr>
            <th colspan="2">parcial</th>
            <th colspan="2"><?php echo $qttCompra ?></th>
          </tr>
        </tfoot>

      </table>
      <?php else : ?>
      <p>No existen eventos para este producto.</p>
      <?php endif; ?>
    </fieldset>
  </div>
</div>

<div class="winAccordion">
  <h2 class="titleSection">Ventas aprobadas (<?php echo count($producto->getVentasFinalizadas()) ?>)</h2>
  <div class="fieldSection">
    <fieldset>
      <?php if (count($producto->getVentasFinalizadas())) : ?>
      <table class="tabla100">
        <thead>
          <tr>
            <th>id</th>
            <th>Fecha</th>
            <th>Cant.</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            <?php $qttVenta = 0; ?>
            <?php foreach ($producto->getVentasFinalizadas() as $venta): ?>
          <tr>
            <td><?php echo $venta->getId() ?></td>
            <td><?php echo $venta->getFecha() ?></td>
            <td><?php echo $venta->getCantidad() ?></td>
            <td></td>
          </tr>
              <?php
              $qttVenta = $venta->getCantidad() + $qttVenta;
              ?>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
          <tr>
            <th colspan="2">parcial</th>
            <th colspan="2"><?php echo $qttVenta ?></th>
          </tr>
        </tfoot>

      </table>
      <?php else : ?>
      <p>No existen eventos para este producto.</p>
      <?php endif; ?>
    </fieldset>
  </div>
</div>

<div class="win_footer">
  <ul class="sf_admin_actions">
    <li enlace="vtnClose" class="sf_admin_action_cancel btn_admin_actions"><div class="icn icn-close"></div>Cerrar</li>
  </ul>
</div>