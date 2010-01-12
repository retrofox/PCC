<?php use_helper('I18N', 'Date', 'mooDooUrl') ?>

<div id="list_win-compra" class="win compra-index">
  <div class="block_win"></div>
  <?php include_partial('compra/winHandle', array ('title' => __('Listado de Compras', array(), 'messages'))) ?>

  <div id="embedded_win-compra"></div>

  <?php include_partial('compra/flashes') ?>

  <div class="sf_admin_content win_content">

    <div class="win_bar bar_menu">
            <a href="#" title="Filtro" >Filtro</a>
      


      <div class="wins_bar">
                <?php include_partial('compra/win_filters', array('form' => $filters, 'configuration' => $configuration)) ?>
              </div>


    </div>

    <div id="sf_admin_content-compra" class="list-container">
      <?php include_partial('compra/win_list_content', array('helper' => $helper, 'pager' => $pager, 'sort' => $sort)) ?>
    </div>

    <div id="sf_admin_footer">
      <?php include_partial('compra/list_footer', array('pager' => $pager)) ?>
    </div>
  </div>

  <div class="win_state">listo.</div>

</div>

<?php include_partial('compra/data_json-list', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper)) ?>