<script type="text/javascript">
// win Edit
<?php include_partial('compra/data_json-edit_win', array('compra' => $compra, 'jsonData4Win' => $jsonData4Win, )) ?>

// Actions
var $actions = new Array ();
$actions = [
  <?php include_partial('compra/data_json-edit_or_new-actions', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
]
</script>