[?php use_javascript('<?php echo sfConfig::get('app_sfPropelMooDooPlugin_js_dir').'/moo-1.2.3.js' ?>', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sfPropelMooDooPlugin_js_dir').'/moo-more-1.2.3.js' ?>', 'first') ?]

<?php if (isset($this->params['css'])): ?>
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?]
<?php else: ?>
[?php use_stylesheet('<?php echo sfConfig::get('app_sfPropelMooDooPlugin_css_dir').'/global.css' ?>', 'first') ?]
<?php endif; ?>
