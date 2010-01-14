<?php use_helper('I18N', 'Date') ?>

<div id="edit_win-producto-<?php echo $producto->getId() ?>" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto/winHandle', array ('title' => __('Edit Product', array(), 'messages'))) ?>

  <div class="sf_admin_form win_content">
    <?php include_partial('producto/formWin', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>

<?php include_partial('producto/data_json-edit', array('producto' => $producto, 'jsonData4Win' => $jsonData4Win, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php if ($sf_request->getParameter('isCommingEdit') == 'true') : ?>
  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    action: <?php echo $helper->mooJsonDataToEditObject($producto, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
  </script>
  <?php endif; ?>