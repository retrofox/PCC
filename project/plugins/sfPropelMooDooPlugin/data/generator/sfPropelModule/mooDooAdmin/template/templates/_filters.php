<div class="btn24x24" id="toggleFilerSlide"><div class="icn icn-flecha-abajo"></div></div>
<ul class="sf_admin_bar_menu">
  <li class="btn110" id="btnFilterOn"><div class="icn icn-filter"></div>[?php echo __('filter') ?]</li>
    [?php echo moo_btn_to_filters(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]





  <?php
    /*  Esto es lo que hacia el boton de reset.
     * Me parece una garcha.
     *
     * (1) Crea un formulario vacio						var f = document.createElement('form');
     * (2) Lo Esconde 									f.style.display = 'none';
     * (3) Lo agrega en un nodo paralelo al acual		this.parentNode.appendChild(f);
     * (4) Define el metodo de envio de datos			f.method = 'POST';
     * (5) Define el action con la URI actual			f.action = this.href;
     * (6) Lo envia										f.submit();
     * (7) Deshabilita el link del anchor				return false;
     * 
     * <li class="btn110"><div class="icn icn-filter-reset"></div>[?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]</li>
     *
     */
  ?>
</ul>


<div class="sf_admin_filter">
  <div id="sf_admin_filter_slide">
	  [?php if ($form->hasGlobalErrors()): ?]
	    [?php echo $form->renderGlobalErrors() ?]
	  [?php endif; ?]
    <form id ="sf_admin_filter_form" action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">
      <table class="sf_admin_filter_filters" cellspacing="0">
        <tbody>
          <tr>
	        [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
	        [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
	          [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
	            'name'       => $name,
	            'attributes' => $field->getConfig('attributes', array()),
	            'label'      => $field->getConfig('label'),
	            'help'       => $field->getConfig('help'),
	            'form'       => $form,
	            'field'      => $field,
	            'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
	          )) ?]
	        [?php endforeach; ?]
          </tr>
        </tbody>
        <tfoot>
	      [?php echo $form->renderHiddenFields() ?]
        </tfoot>
      </table>
    </form>
  </div>
</div>