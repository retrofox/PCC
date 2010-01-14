<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>
<?php include_partial('producto/assets_list') ?>

<div id="sf_admin_container-index-producto" class="sf_admin_container producto-index">
  <div id="winsEmbedded_index-producto"></div>
  <?php include_partial('producto/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('producto/list_header', array('pager' => $pager)) ?>
  </div>

    <div id="sf_admin_bar">
    <div id="sf_filter_admin_bar">
      <?php include_partial('producto/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
  </div>
  
  <div id="sf_admin_content">
        <form id="sf_admin_list_form_method-producto" class="hiddenForm" method="post">
      <input value="delete" name="sf_method" type="hidden">
    </form>

        <form id="sf_admin_content_form" action="<?php echo url_for('producto_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('producto/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <ul class="sf_admin_actions">
        <?php include_partial('producto/list_batch_actions', array('helper' => $helper)) ?>
        <?php include_partial('producto/list_actions', array('helper' => $helper)) ?>
      </ul>
          </form>
      </div>

  <div id="sf_admin_footer">
    <?php include_partial('producto/list_footer', array('pager' => $pager)) ?>
  </div>
</div>