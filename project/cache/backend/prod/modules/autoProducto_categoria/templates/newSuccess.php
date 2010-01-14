<?php use_helper('I18N', 'Date') ?>
<?php include_partial('producto_categoria/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Nueva Categoría de Producto', array(), 'messages') ?></h1>

  <?php include_partial('producto_categoria/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('producto_categoria/form_header', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('producto_categoria/form', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('producto_categoria/form_footer', array('producto_categoria' => $producto_categoria, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>