<?php use_helper('I18N', 'Date') ?>

<div class="win_flashes">
  <?php include_partial('compra/flashesEdit', array('compra' => $compra, 'helper' => $helper, 'isNew' => $isNew)) ?>
</div>

<?php include_partial('compra/formWin', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php include_partial('compra/data_json-edit_content', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>