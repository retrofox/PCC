{
    line: <?php echo $line ?>,
    rendered: false,
    actions: [
      <?php echo $helper->mooJsonDataToEditObject($compra, array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
      <?php echo $helper->mooJsonDataToDeleteObject($compra, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>    ]
  },
