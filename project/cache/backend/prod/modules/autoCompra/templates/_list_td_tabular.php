<td class="sf_admin_date sf_admin_list_th_fecha">
  <?php echo false !== strtotime($compra->getFecha()) ? format_date($compra->getFecha(), "dd/MM/yy") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_th_producto">
  <?php echo $compra->getProducto() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_proveedor">
  <?php echo $compra->getProveedor() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_cantidad">
  <?php echo $compra->getCantidad() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_ultimo_estado">
  <?php echo $compra->getUltimoEstado() ?>
</td>
