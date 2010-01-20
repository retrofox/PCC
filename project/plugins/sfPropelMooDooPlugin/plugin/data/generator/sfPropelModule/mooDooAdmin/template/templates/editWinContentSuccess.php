[?php use_helper('I18N', 'Date') ?]

<div class="win_flashes">
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashesEdit', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper, 'isNew' => $isNew)) ?]
</div>

[?php include_partial('<?php echo $this->getModuleName() ?>/formWin', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]

[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-edit_content', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]