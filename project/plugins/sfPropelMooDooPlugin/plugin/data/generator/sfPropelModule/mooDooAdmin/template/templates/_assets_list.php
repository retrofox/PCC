[?php //use_javascript($sf_request->getScriptName().'/mooDoo/moo-123.js', 'first') ?]
[?php //use_javascript($sf_request->getScriptName().'/mooDoo/moo-more-123.js', 'first') ?]

[?php use_javascript($sf_request->getScriptName().'/mooDoo/sfMoo-global.js', 'last') ?]
[?php use_javascript($sf_request->getScriptName().'/mooDoo/core.js', 'last') ?]
[?php use_javascript($sf_request->getScriptName().'/mooDoo/mooWinManager_class.js', 'last') ?]
[?php use_javascript($sf_request->getScriptName().'/mooDoo/sfMooWin_class.js', 'last') ?]

[?php use_javascript($sf_request->getScriptName().'/mooDoo/'.$this->getModuleName().'/data_json-list.json', 'first') ?]

<?php if (isset($this->params['css'])): ?>
    [?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?]
<?php else: ?>
    [?php use_stylesheet('<?php echo sfConfig::get('app_sfPropelMooDooPlugin_css_dir').'/global.css' ?>', 'first') ?]
    [?php use_stylesheet('<?php echo sfConfig::get('app_sfPropelMooDooPlugin_css_dir').'/list.css' ?>', 'first') ?]
<?php endif; ?>

[?php use_stylesheet('<?php echo sfConfig::get('sf_project_css_dir').'/css/'.$this->getModuleName().'.css' ?>', 'last') ?]
