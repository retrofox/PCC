<?php use_helper('I18N', 'Date') ?>

<div class="win_flashes">
  <?php include_partial('producto_udm/flashesEdit', array('producto_udm' => $producto_udm, 'helper' => $helper, 'isNew' => $isNew)) ?>
</div>

<?php include_partial('producto_udm/formWin', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php include_partial('producto_udm/data_json-edit_content', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>