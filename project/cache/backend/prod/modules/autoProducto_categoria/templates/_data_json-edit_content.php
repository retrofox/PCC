<script type="text/javascript">
// Actions editWin
var $actions = new Array ();
$actions = [
  <?php include_partial('producto_categoria/data_json-edit_or_new-actions', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>