[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>', array ('id' => '')) ?]

    [?php echo $form->renderHiddenFields() ?]

    [?php if ($form->hasGlobalErrors()): ?]
      [?php echo $form->renderGlobalErrors() ?]
    [?php endif; ?]

      [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
        [?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
      [?php endforeach; ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/form_actionsWin', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
</form>

<?php // Usamos este formulario eventualmente para eliminar el objeto/registro. No usamos el metodo intrusivo de symfony. ?>
<form class="hiddenForm" method="post">
  <input value="delete" name="sf_method" type="hidden">
</form>
