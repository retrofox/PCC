<?php use_helper('I18N', 'Date') ?>
<div id="new_win-compra" class="win">
  <div class="block_win"></div>
  <?php include_partial('compra/winHandle', array ('title' => __('Compra de Producto', array(), 'messages'))) ?>
 
  <div class="sf_admin_form win_content">
    <?php include_partial('compra/formWin', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>
<?php include_partial('compra/data_json-new', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>