<div class="win_footer">
  <ul class="sf_admin_actions">
        	<?php if ($form->isNew()): ?>
                <?php echo $helper->mooLinkToDelete($compra, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',  'mooBOA' => 'btn_admin_actions',)) ?>    
    
            <?php echo $helper->mooLinkToCancel(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
    
            <?php echo $helper->mooLinkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>
    
        
        
            	<?php else: ?>
                <?php echo $helper->mooLinkToDelete($compra, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',  'mooBOA' => 'btn_admin_actions',)) ?>    
    
            <?php echo $helper->mooLinkToCancel(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
    
            <?php echo $helper->mooLinkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>
    
        
        
        	<?php endif; ?>
	</ul>
</div>