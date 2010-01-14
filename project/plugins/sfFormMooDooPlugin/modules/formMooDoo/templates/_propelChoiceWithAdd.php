<script type="text/javascript">
  var $server_response = new Array ();
  $server_response = {
    is_ok: <?php echo ($form_field->hasError()) ? 'false' : 'true' ?>,
<?php if (!$form_field->hasError()) : ?>
    options: [
  <?php foreach ($select_elements as $clave => $valor) : ?>
    {id: <?php echo $valor['ID'] ?>, value: '<?php echo $valor['NOMBRE'] ?>'},
  <?php endforeach ; ?>
  ],
  id_selected: <?php echo $id_selected ?>
<?php endif; ?>
  }
</script>

<?php if (!$form_field->hasError()) : ?>
  <div class="ok_list">
    <ul><li>Categr&iacute;a agregada correctamente.</li></ul>
  </div>
<?php else : ?>
  <div class="error_list">
  <?php echo $form_field->getError() ?>
  </div>
<?php endif; ?>