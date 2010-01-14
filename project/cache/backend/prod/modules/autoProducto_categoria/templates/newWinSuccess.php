<?php use_helper('I18N', 'Date') ?>
<div id="new_win-producto_categoria" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto_categoria/winHandle', array ('title' => __('Nueva Categoría de Producto', array(), 'messages'))) ?>
 
  <div class="sf_admin_form win_content">
    <?php include_partial('producto_categoria/formWin', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>
<?php include_partial('producto_categoria/data_json-new', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>