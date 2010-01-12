<?php use_helper('I18N', 'Date') ?>
  <div class="win_flashes">
    <?php include_partial('compra/flashesEdit', array('compra' => $compra, 'helper' => $helper, 'isNew' => $isNew)) ?>
  </div>

<?php echo form_tag_for($form, '@compra') ?>

    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('compra/form_fieldset', array('compra' => $compra, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('compra/form_actionsWin', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
</form>

<?php
if ($sf_user->getFlash('isNew')) {
  include_partial('compra/data_json-new', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper));
}
?>