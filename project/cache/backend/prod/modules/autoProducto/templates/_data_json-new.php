<script type="text/javascript">
// JsonData newWin

  // JSON Data objWin
  <?php include_partial('producto/data_json-new_win', array('producto' => $producto)) ?>


  // Actions
  var $actions = new Array ();
  $actions = [
    <?php include_partial('producto/data_json-edit_or_new-actions', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  ]
</script>