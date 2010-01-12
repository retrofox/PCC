<?php use_helper('I18N', 'Date') ?>

<div id="new_win-recalc-<?php echo $producto->getId() ?>" class="win">
  <div class="block_win"></div>
  <?php include_partial('producto/winHandle', array ('title' => __('Historial de Producto', array(), 'messages'))) ?>

  <div class="sf_admin_form win_content">
    <?php include_partial('producto/recalc_content', array('producto' => $producto, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="win_state">listo.</div>
</div>

<script type="text/javascript">
  var $jsonData4Win = new Array ();
  $jsonData4Win = <?php echo json_encode($win) ?>

  // Actions
  var $actions = new Array ();
  $actions = [
    <?php //echo $helper->mooJsonDataToDeleteObject($producto, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    {type: 'ajax_link', link: '<?php echo url_for('producto/recalc?id='.$producto->getId().'&recalcNow=true') ?>', update: '_this', execute: 'renderAjaxNewWin'},
    <?php echo $helper->mooJsonDataToWinCancel(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
  ]
</script>
