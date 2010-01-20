  [?php use_helper('I18N', 'Date', 'mooDooUrl') ?]

  <?php   // Usamos este formulario para la accion de borrar de un objeto del listado.
          // No usamos el metodo de symfony intrusivo.
  ?>
  <form id="sf_admin_list_form_method-<?php echo $this->getModuleName() ?>" class="hiddenForm" method="post">
    <input value="delete" name="sf_method" type="hidden">
  </form>

  <?php if ($this->configuration->getValue('list.batch_actions')): ?>
  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
    <?php endif; ?>
    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
    <ul class="sf_admin_actions">
      [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
      [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
    </ul>
    <?php if ($this->configuration->getValue('list.batch_actions')): ?>
  </form>
  <?php endif; ?>

[?php if ($only_list) {
  include_partial('<?php echo $this->getModuleName() ?>/data_json-list_content', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper));
};
?]