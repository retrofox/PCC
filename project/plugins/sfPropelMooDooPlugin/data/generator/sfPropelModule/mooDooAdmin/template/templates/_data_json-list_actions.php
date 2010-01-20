{
    line: [?php echo $line ?],
    rendered: false,
    actions: [
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if ('_delete' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->mooJsonDataToDeleteObject($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
<?php elseif ('_edit' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->mooJsonDataToEditObject($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_list' == $name): ?>
      <?php echo $this->addCredentialCondition('[?php echo $helper->mooJsonDataToListObjects($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php else: ?>
      <?php echo $this->addCredentialCondition($this->mooJsonDataToAction($name, $params, true, $params['class_suffix']), $params); ?>
<?php endif; ?>
<?php endforeach; ?>
    ]
  },
