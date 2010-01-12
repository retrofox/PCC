<script type="text/javascript">
// JsonData newWin

  // JSON Data objWin
  <?php include_partial('compra/data_json-new_win', array('compra' => $compra)) ?>


  // Actions
  var $actions = new Array ();
  $actions = [
    <?php include_partial('compra/data_json-edit_or_new-actions', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  ]
</script>