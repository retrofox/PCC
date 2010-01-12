<?php if ($field->isPartial()): ?>
  <?php include_partial('producto/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('producto', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderError() ?>


<?php if ($name == 'producto_categoria_id') : ?>
    <table class="select_with_add">
      <tr>
        <td><?php echo $form[$name]->renderLabel($label) ?></td>
        <td><?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?></td>
        <td class="btn24x24 content_win">
        <div class="icn icn-add btn_add2Select4Win">
	        <div class="win4add2select">
	        	<input link_to_add="<?php echo url_for ('producto/createCategoria') ?>" name="add2select" value="nuevo valor" />
	        	<div class="btn24x24"><div class="icn icn-delete"></div></div>
	        	<div class="btn24x24"><div class="icn icn-submit"></div></div>
	        </div>
	       </div>
        </td>

      </tr>
    </table>

<?php elseif ($name == 'producto_udm_id') : ?>
    <table class="select_with_add">
      <tr>
        <td><?php echo $form[$name]->renderLabel($label) ?></td>
        <td><?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?></td>
        <td class="btn24x24 content_win">
        <div class="icn icn-add btn_add2Select4Win">
	        <div class="win4add2select">
	        		<input link_to_add="<?php echo url_for ('producto/createUDM') ?>" name="add2select" value="nuevo valor" />
	        	<div class="btn24x24"><div class="icn icn-delete"></div></div>
	        	<div class="btn24x24"><div class="icn icn-submit"></div></div>
	        </div>
	       </div>
        </td>

      </tr>
    </table>

<?php else : ?>

    <div>
      <?php echo $form[$name]->renderLabel($label) ?>
      <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
    </div>

<?php endif; ?>

      <?php if ($help || $help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php endif; ?>

  </div>
<?php endif; ?>