<?php if ($sf_user->hasFlash('notice-compra-edit')): ?>
<div class="notice_msg">
  <?php echo __($sf_user->getFlash('notice-compra-edit'), array(), 'sf_admin') ?>
</div>

<script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    auto_action: 'close_and_parent_refresh',
    action: <?php echo $helper->mooJsonDataToEditObject($compra, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?>
  }
</script>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error-compra-edit')): ?>
<div class="error_msg">
  <?php echo __($sf_user->getFlash('error-compra-edit'), array(), 'sf_admin') ?>
</div>

  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'error'
  }
  </script>
<?php endif; ?>