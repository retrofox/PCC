<td class="sf_admin_text sf_admin_list_th_id">
  <?php echo link_to($producto->getId(), 'producto_edit', $producto) ?>
</td>
<td class="sf_admin_text sf_admin_list_th_codigo">
  <?php echo $producto->getCodigo() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_nombre">
  <?php echo $producto->getNombre() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_stock_actual">
  <?php echo $producto->getStockActual() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_ubicacion_fisica">
  <?php echo $producto->getUbicacionFisica() ?>
</td>
