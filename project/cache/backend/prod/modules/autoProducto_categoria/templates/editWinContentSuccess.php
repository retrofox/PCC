<?php use_helper('I18N', 'Date') ?>

<div class="win_flashes">
  <?php include_partial('producto_categoria/flashesEdit', array('producto_categoria' => $producto_categoria, 'helper' => $helper, 'isNew' => $isNew)) ?>
</div>

<?php include_partial('producto_categoria/formWin', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php include_partial('producto_categoria/data_json-edit_content', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>