<script type="text/javascript">
// JsonData newWin

  // JSON Data objWin
  [?php include_partial('<?php echo $this->getModuleName() ?>/data_json-new_win', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]


  // Actions
  var $actions = new Array ();
  $actions = [
    [?php include_partial('<?php echo $this->getModuleName() ?>/data_json-edit_or_new-actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  ]
</script>