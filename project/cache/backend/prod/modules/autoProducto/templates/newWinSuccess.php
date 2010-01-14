<?php use_helper('I18N', 'Date') ?>
<div id="new_win-producto" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto/winHandle', array ('title' => __('New Product', array(), 'messages'))) ?>
 
  <div class="sf_admin_form win_content">
    <?php include_partial('producto/formWin', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>
<?php include_partial('producto/data_json-new', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>