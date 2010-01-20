[?php use_helper('I18N', 'Date') ?]
<div id="new_win-<?php echo $this->params['route_prefix'] ?>" class="win">
  <div class="block_win"></div>
  [?php include_partial('<?php echo $this->getModuleName()?>/winHandle', array ('title' => <?php echo $this->getI18NString('new.title') ?>)) ?]
 
  <div class="sf_admin_form win_content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/formWin', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </div>

  <div class="win_state">listo.</div>
</div>
[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-new', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]