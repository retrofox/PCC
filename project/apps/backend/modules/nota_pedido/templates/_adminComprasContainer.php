<?php use_helper('I18N', 'Date') ?>
<?php include_partial('nota_pedido/adminComprasContent', array('nota_pedido' => $nota_pedido, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
<?php include_partial('nota_pedido/data_json-compras', array('nota_pedido' => $nota_pedido, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
