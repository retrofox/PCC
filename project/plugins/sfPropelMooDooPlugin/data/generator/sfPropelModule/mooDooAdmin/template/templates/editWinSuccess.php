[?php use_helper('I18N', 'Date') ?]

<div id="edit_win-<?php echo $this->params['route_prefix'] ?>-[?php echo <?php echo $this->getPKeysStringIdentifiers() ?> ?]" class="win">
  <div class="block_win"></div>
  [?php include_partial('<?php echo $this->getModuleName()?>/winHandle', array ('title' => <?php echo $this->getI18NString('edit.title') ?>)) ?]

  <div class="sf_admin_form win_content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/formWin', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </div>

  <div class="win_state">listo.</div>
</div>

[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-edit', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'jsonData4Win' => $jsonData4Win, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]

[?php if ($sf_request->getParameter('isCommingEdit') == 'true') : ?>
  <script type="text/javascript">
  $flashEditResponse = new Array ();
  $flashEditResponse = {
    action_state: 'ok',
    was_new: true,
    action: [?php echo $helper->mooJsonDataToEditObject($<?php echo $this->getSingularName() ?>, array('inWinPopUp' => true, 'class_suffix' => 'edit', 'label' => 'Edit')); ?]
  }
  </script>
  [?php endif; ?]