<div class="btn24x24" id="toggleFilerSlide"><div class="icn icn-flecha-abajo"></div></div>
<ul class="sf_admin_bar_menu">
  <li class="btn110" id="btnFilterOn"><div class="icn icn-filter"></div><?php echo __('filter') ?></li>
    <?php echo moo_btn_to_filters(__('Reset', array(), 'sf_admin'), 'compra_collection', array('action' => 'filter')) ?>





  </ul>


<div class="sf_admin_filter">
  <div id="sf_admin_filter_slide">
	  <?php if ($form->hasGlobalErrors()): ?>
	    <?php echo $form->renderGlobalErrors() ?>
	  <?php endif; ?>
    <form id ="sf_admin_filter_form" action="<?php echo url_for('compra_collection', array('action' => 'filter')) ?>" method="post">
      <table class="sf_admin_filter_filters" cellspacing="0">
        <tbody>
          <tr>
	        <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
	        <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
	          <?php include_partial('compra/filters_field', array(
	            'name'       => $name,
	            'attributes' => $field->getConfig('attributes', array()),
	            'label'      => $field->getConfig('label'),
	            'help'       => $field->getConfig('help'),
	            'form'       => $form,
	            'field'      => $field,
	            'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
	          )) ?>
	        <?php endforeach; ?>
          </tr>
        </tbody>
        <tfoot>
	      <?php echo $form->renderHiddenFields() ?>
        </tfoot>
      </table>
    </form>
  </div>
</div>