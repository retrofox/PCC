<td colspan="5">
  <?php echo __('%%id%% - %%codigo%% - %%nombre%% - %%stock_actual%% - %%ubicacion_fisica%%', array('%%id%%' => link_to($producto->getId(), 'producto_edit', $producto), '%%codigo%%' => $producto->getCodigo(), '%%nombre%%' => $producto->getNombre(), '%%stock_actual%%' => $producto->getStockActual(), '%%ubicacion_fisica%%' => $producto->getUbicacionFisica()), 'messages') ?>
</td>
