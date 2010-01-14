<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>
<?php include_partial('producto_udm/assets_list') ?>

<div id="sf_admin_container-index-producto_udm" class="sf_admin_container producto_udm-index">
  <div id="winsEmbedded_index-producto_udm"></div>
  <?php include_partial('producto_udm/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('producto_udm/list_header', array('pager' => $pager)) ?>
  </div>

    <div id="sf_admin_bar">
    <div id="sf_filter_admin_bar">
      <?php include_partial('producto_udm/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
  </div>
  
  <div id="sf_admin_content">
        <form id="sf_admin_list_form_method-producto_udm" class="hiddenForm" method="post">
      <input value="delete" name="sf_method" type="hidden">
    </form>

        <form id="sf_admin_content_form" action="<?php echo url_for('producto_udm_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('producto_udm/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <ul class="sf_admin_actions">
        <?php include_partial('producto_udm/list_batch_actions', array('helper' => $helper)) ?>
        <?php include_partial('producto_udm/list_actions', array('helper' => $helper)) ?>
      </ul>
          </form>
      </div>

  <div id="sf_admin_footer">
    <?php include_partial('producto_udm/list_footer', array('pager' => $pager)) ?>
  </div>
</div>