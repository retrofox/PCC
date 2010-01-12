<?php use_helper('I18N', 'Date') ?>
<?php include_partial('producto/assets') ?>

<div id="sf_admin_container-edit" class="sf_admin_container">
  <h1><?php echo __('Edit Product', array(), 'messages') ?></h1>

  <?php include_partial('producto/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('producto/form_header', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('producto/form', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('producto/form_footer', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
