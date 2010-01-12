<script type="text/javascript">
// win Edit
<?php include_partial('producto/data_json-edit_win', array('producto' => $producto, 'jsonData4Win' => $jsonData4Win, )) ?>

// Actions
var $actions = new Array ();
$actions = [
  <?php include_partial('producto/data_json-edit_or_new-actions', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>