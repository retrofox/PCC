<?php if ($field->isPartial()): ?>
  <?php include_partial('producto_categoria/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('producto_categoria', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <div class="labelHeader"><?php echo $form[$name]->renderLabel($label) ?></div>
    <div>
      <?php echo $form[$name]->renderError() ?>

      <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>

      <?php if ($help || $help = $form[$name]->renderHelp()): ?>
      <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php endif; ?>
  </div>

<?php endif; ?>