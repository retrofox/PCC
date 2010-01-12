<div class="sf_admin_form_row<?php echo ($form['proveedor_id']->hasError()) ? ' errors' : '' ?>">
  <?php echo $form['proveedor_id']->renderError() ?>

  <div>
    <label>Proveedor:</label>

    <?php echo $form['proveedor_id'] ?>
  </div>
</div>