<?php if ($form->isNew()): ?>
<?php echo $helper->mooJsonDataToDeleteObject($producto_categoria, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',), 'new') ?>
<?php echo $helper->mooJsonDataToWinCancel(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
<?php echo $helper->mooJsonDataToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>


<?php else: ?>
<?php echo $helper->mooJsonDataToDeleteObject($producto_categoria, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',), 'edit') ?>
<?php echo $helper->mooJsonDataToWinCancel(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
<?php echo $helper->mooJsonDataToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>


<?php endif; ?>