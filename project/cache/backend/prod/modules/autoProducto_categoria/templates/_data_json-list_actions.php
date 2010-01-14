{
    line: <?php echo $line ?>,
    rendered: false,
    actions: [
      <?php echo $helper->mooJsonDataToEditObject($producto_categoria, array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
      <?php echo $helper->mooJsonDataToDeleteObject($producto_categoria, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>    ]
  },
