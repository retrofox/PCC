<?php use_helper('I18N', 'Date') ?>
<?php include_partial('producto_udm/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Nueva Unidad de Medida', array(), 'messages') ?></h1>

  <?php include_partial('producto_udm/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('producto_udm/form_header', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('producto_udm/form', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('producto_udm/form_footer', array('producto_udm' => $producto_udm, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>