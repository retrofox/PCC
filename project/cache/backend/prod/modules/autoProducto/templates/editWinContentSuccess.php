<?php use_helper('I18N', 'Date') ?>

<div class="win_flashes">
  <?php include_partial('producto/flashesEdit', array('producto' => $producto, 'helper' => $helper, 'isNew' => $isNew)) ?>
</div>

<?php include_partial('producto/formWin', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php include_partial('producto/data_json-edit_content', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>