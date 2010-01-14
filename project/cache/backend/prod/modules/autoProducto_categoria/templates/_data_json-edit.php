<script type="text/javascript">
// win Edit
<?php include_partial('producto_categoria/data_json-edit_win', array('producto_categoria' => $producto_categoria, 'jsonData4Win' => $jsonData4Win, )) ?>

// Actions
var $actions = new Array ();
$actions = [
  <?php include_partial('producto_categoria/data_json-edit_or_new-actions', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>