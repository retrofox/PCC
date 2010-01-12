<script type="text/javascript">
  var $server_response = new Array ();
  $server_response = {
    is_ok: <?php echo ($ProductoCategoriaForm['nombre']->hasError()) ? 'false' : 'true' ?>,
<?php if (!$ProductoCategoriaForm['nombre']->hasError()) : ?>
    options: [
  <?php foreach ($categorias as $clave => $valor) : ?>
    {id: <?php echo $valor['ID'] ?>, value: '<?php echo $valor['NOMBRE'] ?>'},
  <?php endforeach ; ?>
  ],
  id_selected: <?php echo $categoria_id ?>
<?php endif; ?>
  }
</script>

<?php if (!$ProductoCategoriaForm['nombre']->hasError()) : ?>
  <div class="ok_list">
    <ul><li>Categr&iacute;a agregada correctamente.</li></ul>
  </div>
<?php else : ?>
  <div class="error_list">
  <?php echo $ProductoCategoriaForm['nombre']->renderError() ?>
  </div>
<?php endif; ?>