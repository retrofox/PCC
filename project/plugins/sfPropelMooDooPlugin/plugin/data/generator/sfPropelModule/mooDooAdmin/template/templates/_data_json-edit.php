<script type="text/javascript">
// win Edit
[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-edit_win', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'jsonData4Win' => $jsonData4Win, )) ?]

// Actions
var $actions = new Array ();
$actions = [
  [?php include_partial('<?php echo $this->getModuleName() ?>/data_json-edit_or_new-actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
]
</script>