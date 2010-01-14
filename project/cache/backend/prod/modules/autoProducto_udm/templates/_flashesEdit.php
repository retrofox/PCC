<?php if ($sf_user->hasFlash('notice-producto_udm-edit')): ?>
<div class="notice_msg">
  <?php echo __($sf_user->getFlash('notice-producto_udm-edit'), array(), 'sf_admin') ?>
</div>

<script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    auto_action: 'close_and_parent_refresh',
    action: <?php echo $helper->mooJsonDataToEditObject($producto_udm, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
</script>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error-producto_udm-edit')): ?>
<div class="error_msg">
  <?php echo __($sf_user->getFlash('error-producto_udm-edit'), array(), 'sf_admin') ?>
</div>

  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'error'
  }
  </script>
<?php endif; ?>