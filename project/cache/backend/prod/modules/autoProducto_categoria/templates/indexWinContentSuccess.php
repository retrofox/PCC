<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>
<?php include_partial('producto_categoria/flashes') ?>

    <div class="win_bar bar_menu">
            <a href="#" title="Filtro" >Filtro</a>
      
      <div class="wins_bar">
                <?php include_partial('producto_categoria/win_filters', array('form' => $filters, 'configuration' => $configuration)) ?>
              </div>
    </div>
    <div id="sf_admin_content-producto_categoria" class="list-container">
      <?php include_partial('producto_categoria/win_list_content', array('helper' => $helper, 'pager' => $pager, 'sort' => $sort)) ?>
    </div>

    <div id="sf_admin_footer">
      <?php include_partial('producto_categoria/list_footer', array('pager' => $pager)) ?>
    </div>

<?php include_partial('producto_categoria/data_json-list_content', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper)) ?>