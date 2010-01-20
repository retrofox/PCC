<td class="sf_admin_td_actions">
  <div class="btn-action"><div class="icn icn-action-edit"></div></div>
  <ul class="sf_admin_ul_actions">
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->moolinkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_edit' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->mooLinkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

    <?php //echo $this->addCredentialCondition('[?php echo $helper->mooAjaxLinkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
<?php else: ?>
      <?php
      if (isset($params['inWinPopUp']) and $params['inWinPopUp'] == true) echo $this->addCredentialCondition($this->getAjaxBtnToTdAction($name, $params, true, $params['class_suffix']), $params);
      else echo $this->addCredentialCondition($this->getBtnToTdAction($name, $params, true, $params['class_suffix']), $params);
      ?>
<?php endif; ?>
<?php endforeach; ?>
  </ul>
</td>