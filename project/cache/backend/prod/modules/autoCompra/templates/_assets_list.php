<?php //use_javascript($sf_request->getScriptName().'/mooDoo/moo-123.js', 'first') ?>
<?php //use_javascript($sf_request->getScriptName().'/mooDoo/moo-more-123.js', 'first') ?>

<?php use_javascript($sf_request->getScriptName().'/mooDoo/sfMoo-global.js', 'last') ?>
<?php use_javascript($sf_request->getScriptName().'/mooDoo/core.js', 'last') ?>
<?php use_javascript($sf_request->getScriptName().'/mooDoo/mooWinManager_class.js', 'last') ?>
<?php use_javascript($sf_request->getScriptName().'/mooDoo/sfMooWin_class.js', 'last') ?>

<?php use_javascript($sf_request->getScriptName().'/mooDoo/'.$this->getModuleName().'/data_json-list.json', 'first') ?>

    <?php use_stylesheet('../sfPropelMooDooPlugin/css/global.css', 'first') ?>
    <?php use_stylesheet('../sfPropelMooDooPlugin/css/list.css', 'first') ?>

<?php use_stylesheet('/css/compra.css', 'last') ?>
