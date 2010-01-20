// JsonData Actions list
  var $jsonDataObjActionsList = new Array ();
    $jsonDataObjActionsList = {
      global: {
        update: '_new'
      },
      objects: [
  [?php foreach ($pager->getResults() as $i => $<?php echo $this->getSingularName() ?>): ?]
  <?php if ($this->configuration->getValue('list.object_actions')): ?>
    [?php include_partial('<?php echo $this->getModuleName() ?>/data_json-list_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper, 'line' => $i)) ?]
  <?php endif; ?>
  [?php endforeach; ?]
 ]};