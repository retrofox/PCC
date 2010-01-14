<td class="sf_admin_td_actions">
  <div class="btn-action"><div class="icn icn-action-edit"></div></div>
  <ul class="sf_admin_ul_actions">
    <?php echo $helper->mooLinkToEdit($producto, array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
        <?php echo $helper->moolinkToDelete($producto, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
      <?php echo '<li class="mooBOA obj_act-evento"><div class="icn icn-evento"></div>'.__('Agregar Evento').'</li>' ?>      <?php echo '<li class="mooBOA obj_act-comprar"><div class="icn icn-comprar"></div>'.__('Agregar Compra').'</li>' ?>      <?php echo '<li class="mooBOA obj_act-venta"><div class="icn icn-venta"></div>'.__('Realizar Venta').'</li>' ?>      <?php echo '<li class="mooBOA obj_act-recalc"><div class="icn icn-recalc"></div>'.__('Stock de Producto').'</li>' ?>  </ul>
</td>