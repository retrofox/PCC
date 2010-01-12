<?php 
foreach ($options as $option) : ?>
	<?php if ($select2Add->getId() == $option->getId()) : ?>
		<option selected="selected" value="<?php echo $option->getId() ?>"><?php echo $option->getNombre() ?></option>
	<?php else : ?>
		<option value="<?php echo $option->getId() ?>"><?php echo $option->getNombre() ?></option>
	<?php endif; ?>
<?php endforeach; ?>