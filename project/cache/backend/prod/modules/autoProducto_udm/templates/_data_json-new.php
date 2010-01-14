<script type="text/javascript">
// JsonData newWin

  // JSON Data objWin
  <?php include_partial('producto_udm/data_json-new_win', array('producto_udm' => $producto_udm)) ?>


  // Actions
  var $actions = new Array ();
  $actions = [
    <?php include_partial('producto_udm/data_json-edit_or_new-actions', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  ]
</script>