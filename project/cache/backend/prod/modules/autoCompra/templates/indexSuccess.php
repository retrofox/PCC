<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>
<?php include_partial('compra/assets_list') ?>

<div id="sf_admin_container-index-compra" class="sf_admin_container compra-index">
  <div id="winsEmbedded_index-compra"></div>
  <?php include_partial('compra/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('compra/list_header', array('pager' => $pager)) ?>
  </div>

    <div id="sf_admin_bar">
    <div id="sf_filter_admin_bar">
      <?php include_partial('compra/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
  </div>
  
  <div id="sf_admin_content">
        <form id="sf_admin_list_form_method-compra" class="hiddenForm" method="post">
      <input value="delete" name="sf_method" type="hidden">
    </form>

        <form id="sf_admin_content_form" action="<?php echo url_for('compra_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('compra/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <ul class="sf_admin_actions">
        <?php include_partial('compra/list_batch_actions', array('helper' => $helper)) ?>
        <?php include_partial('compra/list_actions', array('helper' => $helper)) ?>
      </ul>
          </form>
      </div>

  <div id="sf_admin_footer">
    <?php include_partial('compra/list_footer', array('pager' => $pager)) ?>
  </div>
</div>