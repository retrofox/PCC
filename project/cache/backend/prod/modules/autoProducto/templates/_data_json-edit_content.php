<script type="text/javascript">
// Actions editWin
var $actions = new Array ();
$actions = [
  <?php include_partial('producto/data_json-edit_or_new-actions', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>