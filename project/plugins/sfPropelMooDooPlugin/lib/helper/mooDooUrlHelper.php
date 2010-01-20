<?php


function moo_btn_to_filters() {
// for BC with 1.1
  $arguments = func_get_args();
  if (empty($arguments[1]) || '@' == substr($arguments[1], 0, 1) || false !== strpos($arguments[1], '/')) {
    return call_user_func_array('moo_btn_to1', $arguments);
  }
  else {
    if (!array_key_exists(2, $arguments)) {
      $arguments[2] = array();
    }

    $arguments[3]['htmlTag'] = 'li';
    $arguments[3]['addNodeIcn'] = 'div';
    $arguments[3]['icnClass'] = 'icn-filter-reset';
    $arguments[3]['query_string'] = '_reset';
    $arguments[3]['tagHref'] = 'hrefReset';
    $arguments[3]['id'] = 'btnFilterOff';

    return call_user_func_array('moo_btn_to2', $arguments);
  }
}

function moo_json_data_link_to_filters() {
// for BC with 1.1
  $arguments = func_get_args();
  if (empty($arguments[1]) || '@' == substr($arguments[1], 0, 1) || false !== strpos($arguments[1], '/')) {
    return call_user_func_array('moo_btn_to1', $arguments);
  }
  else {
    if (!array_key_exists(2, $arguments)) {
      $arguments[2] = array();
    }

    $arguments[3]['htmlTag'] = 'li';
    $arguments[3]['addNodeIcn'] = 'div';
    $arguments[3]['icnClass'] = 'icn-filter-reset';
    $arguments[3]['query_string'] = '_reset';
    $arguments[3]['tagHref'] = 'hrefReset';
    $arguments[3]['id'] = 'btnFilterOff';

    return call_user_func_array('moo_json_data_link_to_filters_2', $arguments);
  }
}


function moo_btn_to() {
// for BC with 1.1
  $arguments = func_get_args();
  if (empty($arguments[1]) || '@' == substr($arguments[1], 0, 1) || false !== strpos($arguments[1], '/')) {
    return call_user_func_array('moo_btn_to1', $arguments);
  }
  else {
    if (!array_key_exists(2, $arguments)) {
      $arguments[2] = array();
    }
    return call_user_func_array('moo_btn_to2', $arguments);
  }
}


function moo_btn_to2($name, $routeName, $params, $options = array()) {
  $params = array_merge(array('sf_route' => $routeName), is_object($params) ? array('sf_subject' => $params) : $params);

  return moo_btn_to1($name, $params, $options);
}

function moo_btn_to1($name, $internal_uri, $options = array()) {
  $html_options = _parse_attributes($options);

  //$html_options = _convert_options_to_javascript($html_options);

  $absolute = false;
  if (isset($html_options['absolute_url'])) {
    $html_options['absolute'] = $html_options['absolute_url'];
    unset($html_options['absolute_url']);
  }
  if (isset($html_options['absolute'])) {
    $absolute = (boolean) $html_options['absolute'];
    unset($html_options['absolute']);
  }

  $html_options['href'] = url_for($internal_uri, $absolute);
  //echo '<b style="font-size: 8px; color: #F00">'.$html_options['href'].'</b>';

  if (isset($html_options['query_string'])) {
    $html_options['href'] .= '?'.$html_options['query_string'];
    unset($html_options['query_string']);
  }

  if (isset($html_options['anchor'])) {
    $html_options['href'] .= '#'.$html_options['anchor'];
    unset($html_options['anchor']);
  }

  if (is_object($name)) {
    if (method_exists($name, '__toString')) {
      $name = $name->__toString();
    }
    else {
      throw new sfException(sprintf('Object of class "%s" cannot be converted to string (Please create a __toString() method).', get_class($name)));
    }
  }

  if (!strlen($name)) {
    $name = $html_options['href'];
  }

  $tag = 'div';
  if (isset($html_options['htmlTag'])) {
    $tag = $html_options['htmlTag'];
    unset($html_options['htmlTag']);
  }

  if (!isset($html_options['class'])) {
    $html_options['class'] = 'btn110';
  }

  if (isset ($html_options['tagHref'])) {
    $html_options[$html_options['tagHref']] = $html_options['href'];
    unset ($html_options['tagHref']);
    unset($html_options['href']);
  }

  if (isset($html_options['addNodeIcn'])) {
    $tagIcn = $html_options['addNodeIcn'];
    $icnClass = 'icn';

    unset($html_options['addNodeIcn']);

    if (isset($html_options['icnClass'])) {
      $icnClass.= ' '.$html_options['icnClass'];
      unset($html_options['icnClass']);
    }

    return '<'.$tag._tag_options($html_options).'><'.$tagIcn.' class="'.$icnClass.'"></'.$tagIcn.'>'.$name.'</'.$tag.'>';

  }
  else
    return '<'.$tag._tag_options($html_options).'>'.$name.'</'.$tag.'>';
}




function moo_json_data_link_to_filters_2($name, $routeName, $params, $options = array()) {
  $params = array_merge(array('sf_route' => $routeName), is_object($params) ? array('sf_subject' => $params) : $params);

  return moo_json_data_link_to_filters_1($name, $params, $options);
}


function moo_json_data_link_to_filters_1($name, $internal_uri, $options = array()) {
  $html_options = _parse_attributes($options);

  $absolute = false;
  if (isset($html_options['absolute_url'])) {
    $html_options['absolute'] = $html_options['absolute_url'];
    unset($html_options['absolute_url']);
  }
  if (isset($html_options['absolute'])) {
    $absolute = (boolean) $html_options['absolute'];
    unset($html_options['absolute']);
  }

  $href = url_for($internal_uri, $absolute);

  if (isset($html_options['query_string'])) {
    $href .= '?'.$html_options['query_string'];
    unset($html_options['query_string']);
  }

  if (isset($html_options['anchor'])) {
    $href .= '#'.$html_options['anchor'];
    unset($html_options['anchor']);
  }

  return $href;
}

function _get_json_data_token()
{
  // CSRF protection
  $form = new sfForm();
  if ($form->isCSRFProtected())
  {
    $token = sprintf("', %s: '%s", $form->getCSRFFieldName(), $form->getCSRFToken());
    return $token;
  }
  else return '';
}