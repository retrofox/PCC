<div class="sf_admin_filter win green">
  [?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
  [?php endif; ?]
  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">

    [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
    [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
      <div class="filter_block">
        [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
          'name'       => $name,
          'attributes' => $field->getConfig('attributes', array()),
          'label'      => $field->getConfig('label'),
          'help'       => $field->getConfig('help'),
          'form'       => $form,
          'field'      => $field,
          'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
        )) ?]
    </div>
    [?php endforeach; ?]

    [?php echo $form->renderHiddenFields() ?]
  </form>

  <div class="bar_menu filter_btns">
    <a href="#" title="Filtro" >Filtrar</a>
    <a href="#" title="Filtro" >Limpiar</a>
    <a href="#" title="Filtro" >Cancelar</a>
  </div>

</div>

