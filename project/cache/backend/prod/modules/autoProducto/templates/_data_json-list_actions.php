{
    line: <?php echo $line ?>,
    rendered: false,
    actions: [
      <?php echo $helper->mooJsonDataToEditObject($producto, array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
      <?php echo $helper->mooJsonDataToDeleteObject($producto, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>      {type: 'ajax_link', link: '<?php echo url_for('producto/ListEvento?id='.$producto->getId(), array(), 'messages') ?>', link_content: '<?php echo url_for('producto/ListEventoContent?id='.$producto->getId(), array(), 'messages') ?>', update: '_new', execute: 'renderAjaxNewWin'},
      {type: 'ajax_link', link: '<?php echo url_for('producto/ListComprar?id='.$producto->getId(), array(), 'messages') ?>', link_content: '<?php echo url_for('producto/ListComprarContent?id='.$producto->getId(), array(), 'messages') ?>', update: '_new', execute: 'renderAjaxNewWin'},
      {type: 'ajax_link', link: '<?php echo url_for('producto/ListVenta?id='.$producto->getId(), array(), 'messages') ?>', link_content: '<?php echo url_for('producto/ListVentaContent?id='.$producto->getId(), array(), 'messages') ?>', update: '_new', execute: 'renderAjaxNewWin'},
      {type: 'ajax_link', link: '<?php echo url_for('producto/ListRecalc?id='.$producto->getId(), array(), 'messages') ?>', link_content: '<?php echo url_for('producto/ListRecalcContent?id='.$producto->getId(), array(), 'messages') ?>', update: '_new', execute: 'renderAjaxWin', dims: '400xautox100x50'},
    ]
  },
