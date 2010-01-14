<?php use_helper('I18N', 'Date') ?>

<div id="edit_win-producto_categoria-<?php echo $producto_categoria->getId() ?>" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto_categoria/winHandle', array ('title' => __('Edit Producto categoria', array(), 'messages'))) ?>

  <div class="sf_admin_form win_content">
    <?php include_partial('producto_categoria/formWin', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>

<?php include_partial('producto_categoria/data_json-edit', array('producto_categoria' => $producto_categoria, 'jsonData4Win' => $jsonData4Win, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>

<?php if ($sf_request->getParameter('isCommingEdit') == 'true') : ?>
  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    action: <?php echo $helper->mooJsonDataToEditObject($producto_categoria, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
  </script>
  <?php endif; ?>