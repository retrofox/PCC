[?php use_helper('I18N', 'Date', 'mooDooUrl') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

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

[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-list_content', array ('jsonData4Win' => $jsonData4Win, 'pager' => $pager, 'helper' => $helper)) ?]