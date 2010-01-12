<?php use_helper('I18N', 'Date') ?>
  <div class="win_flashes">
    <?php include_partial('producto/flashesEdit', array('producto' => $producto, 'helper' => $helper, 'isNew' => $isNew)) ?>
  </div>

<?php echo form_tag_for($form, '@producto') ?>

    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('producto/form_fieldset', array('producto' => $producto, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('producto/form_actionsWin', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
</form>

<?php
if ($sf_user->getFlash('isNew')) {
  include_partial('producto/data_json-new', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper));
}
?>