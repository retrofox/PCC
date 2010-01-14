<td colspan="5">
  <?php echo __('%%fecha%% - %%producto%% - %%proveedor%% - %%cantidad%% - %%ultimo_estado%%', array('%%fecha%%' => false !== strtotime($compra->getFecha()) ? format_date($compra->getFecha(), "dd/MM/yy") : '&nbsp;', '%%producto%%' => $compra->getProducto(), '%%proveedor%%' => $compra->getProveedor(), '%%cantidad%%' => $compra->getCantidad(), '%%ultimo_estado%%' => $compra->getUltimoEstado()), 'messages') ?>
</td>
