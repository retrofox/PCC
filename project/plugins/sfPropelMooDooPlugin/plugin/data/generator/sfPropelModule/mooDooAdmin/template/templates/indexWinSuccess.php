[?php use_helper('I18N', 'Date', 'mooDooUrl') ?]

<div id="list_win-<?php echo $this->getModuleName() ?>" class="win <?php echo $this->getModuleName() ?>-index">
  <div class="block_win"></div>
  [?php include_partial('<?php echo $this->getModuleName()?>/winHandle', array ('title' => <?php echo $this->getI18NString('list.title') ?>)) ?]

  <div id="embedded_win-<?php echo $this->getModuleName() ?>"></div>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div class="sf_admin_content win_content">

    <div class="win_bar bar_menu">
      <?php if ($this->configuration->hasFilterForm()): ?>
      <a href="#" title="Filtro" >Filtro</a>
      <?php endif; ?>



      <div class="wins_bar">
        <?php if ($this->configuration->hasFilterForm()): ?>
        [?php include_partial('<?php echo $this->getModuleName() ?>/win_filters', array('form' => $filters, 'configuration' => $configuration)) ?]
        <?php endif; ?>
      </div>


    </div>

    <div id="sf_admin_content-<?php echo $this->getModuleName() ?>" class="list-container">
      [?php include_partial('<?php echo $this->getModuleName() ?>/win_list_content', array('helper' => $helper, 'pager' => $pager, 'sort' => $sort)) ?]
    </div>

    <div id="sf_admin_footer">
      [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
    </div>
  </div>

  <div class="win_state">listo.</div>

</div>

[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-list', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper)) ?]