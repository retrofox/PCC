<script type="text/javascript">
// win Edit
<?php include_partial('producto_udm/data_json-edit_win', array('producto_udm' => $producto_udm, 'jsonData4Win' => $jsonData4Win, )) ?>

// Actions
var $actions = new Array ();
$actions = [
  <?php include_partial('producto_udm/data_json-edit_or_new-actions', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>