<?php if (!$sf_user->hasFlash ('nota_de_pedido')) : ?>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_moneda">
    <div>
        <label>Moneda:</label>
        <?php echo $form['moneda']->render() ?>
    </div>
</div>
<?php endif; ?>