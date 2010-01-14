<?php use_helper('I18N', 'Date') ?>
<?php include_partial('compra/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Compra de Producto', array(), 'messages') ?></h1>

  <?php include_partial('compra/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('compra/form_header', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('compra/form', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('compra/form_footer', array('compra' => $compra, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>