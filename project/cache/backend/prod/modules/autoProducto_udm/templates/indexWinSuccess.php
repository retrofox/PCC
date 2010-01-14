<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>

<div id="list_win-producto_udm" class="win producto_udm-index">
  <div class="block_win"></div>
  <?php include_partial('producto_udm/winHandle', array ('title' => __('Unidades de Medida', array(), 'messages'))) ?>

  <div id="embedded_win-producto_udm"></div>

  <?php include_partial('producto_udm/flashes') ?>

  <div class="sf_admin_content win_content">

    <div class="win_bar bar_menu">
            <a href="#" title="Filtro" >Filtro</a>
      


      <div class="wins_bar">
                <?php include_partial('producto_udm/win_filters', array('form' => $filters, 'configuration' => $configuration)) ?>
              </div>


    </div>

    <div id="sf_admin_content-producto_udm" class="list-container">
      <?php include_partial('producto_udm/win_list_content', array('helper' => $helper, 'pager' => $pager, 'sort' => $sort)) ?>
    </div>

    <div id="sf_admin_footer">
      <?php include_partial('producto_udm/list_footer', array('pager' => $pager)) ?>
    </div>
  </div>

  <div class="win_state">listo.</div>

</div>

<?php include_partial('producto_udm/data_json-list', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper)) ?>