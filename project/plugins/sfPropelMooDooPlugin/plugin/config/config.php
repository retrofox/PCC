<?php

// Directorios de los css y js
if (!sfConfig::get('app_sfPropelMooDooPlugin_css_dir')) {
  sfConfig::set('app_sfPropelMooDooPlugin_css_dir', '../sfPropelMooDooPlugin/css');
}

if (!sfConfig::get('app_sfPropelMooDooPlugin_js_dir')) {
  sfConfig::set('app_sfPropelMooDooPlugin_js_dir', '../sfPropelMooDooPlugin/js');
}

