<?php use_helper('I18N', 'Date') ?>
<div id="new_win-producto_udm" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto_udm/winHandle', array ('title' => __('Nueva Unidad de Medida', array(), 'messages'))) ?>
 
  <div class="sf_admin_form win_content">
    <?php include_partial('producto_udm/formWin', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>
<?php include_partial('producto_udm/data_json-new', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>