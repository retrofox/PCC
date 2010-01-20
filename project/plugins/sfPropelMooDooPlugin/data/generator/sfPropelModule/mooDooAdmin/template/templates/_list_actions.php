<?php if ($actions = $this->configuration->getValue('list.actions')): ?>
<?php foreach ($actions as $name => $params): ?>
<?php if ('_new' == $name): ?>
<?php echo $this->addCredentialCondition('[?php echo $helper->mooLinkToNew('.$this->asPhp($params).') ?]', $params) ?>
<?php else: ?>
  	<li><?php echo  $this->addCredentialCondition($this->getBtnToAction($name, $params, false, $params['class_suffix'], 'div')) ?></li>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
