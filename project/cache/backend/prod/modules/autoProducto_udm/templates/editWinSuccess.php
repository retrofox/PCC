<?php use_helper('I18N', 'Date') ?>

<div id="edit_win-producto_udm-<?php echo $producto_udm->getId() ?>" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto_udm/winHandle', array ('title' => __('Edit Producto udm', array(), 'messages'))) ?>

  <div class="sf_admin_form win_content">
    <?php include_partial('producto_udm/formWin', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>

<?php include_partial('producto_udm/data_json-edit', array('producto_udm' => $producto_udm, 'jsonData4Win' => $jsonData4Win, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php if ($sf_request->getParameter('isCommingEdit') == 'true') : ?>
  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    action: <?php echo $helper->mooJsonDataToEditObject($producto_udm, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
  </script>
  <?php endif; ?>