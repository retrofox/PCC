<?php use_helper('I18N', 'Date') ?>
  <div class="win_flashes">
    <?php include_partial('producto_categoria/flashesEdit', array('producto_categoria' => $producto_categoria, 'helper' => $helper, 'isNew' => $isNew)) ?>
  </div>

<?php echo form_tag_for($form, '@producto_categoria') ?>

    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('producto_categoria/form_fieldset', array('producto_categoria' => $producto_categoria, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('producto_categoria/form_actionsWin', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
</form>

<?php
if ($sf_user->getFlash('isNew')) {
  include_partial('producto_categoria/data_json-new', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper));
}
?>