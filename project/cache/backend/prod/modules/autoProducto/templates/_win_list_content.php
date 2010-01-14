  <?php use_helper('I18N', 'Date', 'mooDooUrl') ?>

    <form id="sf_admin_list_form_method-producto" class="hiddenForm" method="post">
    <input value="delete" name="sf_method" type="hidden">
  </form>

    <form action="<?php echo url_for('producto_collection', array('action' => 'batch')) ?>" method="post">
        <?php include_partial('producto/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('producto/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('producto/list_actions', array('helper' => $helper)) ?>
    </ul>
      </form>
  
<?php if ($only_list) {
  include_partial('producto/data_json-list_content', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper));
};
?>