<?php use_helper('I18N', 'Date') ?>

<div id="edit_win-compra-<?php echo $compra->getId() ?>" class="win">
  <div class="block_win"></div>
  <?php include_partial('compra/winHandle', array ('title' => __('Editar Compra', array(), 'messages'))) ?>

  <div class="sf_admin_form win_content">
    <?php include_partial('compra/formWin', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>

<?php include_partial('compra/data_json-edit', array('compra' => $compra, 'jsonData4Win' => $jsonData4Win, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php if ($sf_request->getParameter('isCommingEdit') == 'true') : ?>
  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    action: <?php echo $helper->mooJsonDataToEditObject($compra, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
  </script>
  <?php endif; ?>