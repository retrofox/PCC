[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 12482 2008-10-31 11:13:22Z damian $
 */
class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function linkToNew($params)
  {
    return '<li class="sf_admin_action_new">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('new')).'</li>';
  }
  
  public function mooLinkToNew($params, $cssClass='btn_admin_actions')
  {
    return '<li class="'.$isAjaxBtn.$cssClass.' sf_admin_action_new"><div class="icn icn-new"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }

  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</li>';
  }

  public function mooLinkToEdit($object, $params)
  {
    $params['cssClass'] = (isset($params['cssClass'])) ? $params['cssClass'] : 'mooBOA';
    $params['icnClass'] = (isset($params['icnClass'])) ? $params['icnClass'] : 'icn-edit'; 		 
    return '<li class="'.$params['cssClass'].' obj_act-edit"><div class="icn '.$params['icnClass'].'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }
  
  public function mooAjaxLinkToEdit($object, $params, $cssClass = 'icn-edit')
  {
	    //$arrJson = array ('update'=> 'vtn-'.$this->getModuleName().'-index');
	    echo $this->params['route_prefix'];
/*	    
		$options = json_encode($arrJson);
		$options = str_ireplace("\"", "\'", $options);
*/
    //return '<li class="sf_admin_action_edit" options="'.$options.'" ajax_enlace="'.url_for($this->getUrlForAction('edit'), $object).'"><div class="icn '.$cssClass.'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
    return '<li class="sf_admin_action_edit" enlace="'.url_for($this->getUrlForAction('edit'), $object).'"><div class="icn '.$cssClass.'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }
  

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('method' => 'delete', 'confirm' => $params['confirm'])).'</li>';
  }

  public function mooLinkToDelete($object, $params, $module = '')
  {
    if ($object->isNew())
    {
      return '';
    }

    $btnClass = (isset($params['mooBOA'])) ? $params['mooBOA'] : 'mooBOA';
    $icnClass = (isset($params['icn-delete'])) ? $params['icn-delete'] : 'icn-delete';

    return '<li class="'.$btnClass.' obj_act-delete"><div class="icn '.$icnClass.'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }


  public function linkToList($params)
  {
    return '<li class="sf_admin_action_list">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('list')).'</li>';
  }

  public function mooLinkToList($params, $cssClass="btn_admin_actions", $icnClass='icn-delete')
  {
    return '<li class="sf_admin_action_list '.$cssClass.'" enlace="'.url_for($this->getUrlForAction('list')).'"><div class="icn icn-'.$params['label'].'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }

  public function mooLinkToCancel($params, $cssClass="btn_admin_actions", $icnClass='icn-delete')
  {
    return '<li class="sf_admin_action_cancel '.$cssClass.'" enlace="vtnClose"><div class="icn icn-'.$params['label'].'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }

  public function linkToSave($object, $params)
  {
    return '<li class="sf_admin_action_save"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" /></li>';
  }

  public function mooLinkToSave($object, $params, $cssClass="btn_admin_actions", $icnClass = 'icn-save')
  {
    return '<li class="sf_admin_action_save '.$cssClass.'" link_save="save"><div class="icn '.$icnClass.'"></div>'.__($params['label'], array(), 'sf_admin').'</li>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_save_and_add"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_add" /></li>';
  }
/*
  public function getUrlForAction($action, $module)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }
*/

  public function getUrlForAction($action, $module = '')
  {
    $module_action = $module ? $module : '<?php echo $this->params['route_prefix'] ?>';
    return 'list' == $action ? $module_action : $module_action.'_'.$action;
  }


  // Helpers para acciones de objetos en formato JSON - list
  public function mooJsonDataToDeleteObject($object, $params, $action, $module = '')
  {
    if ($object->isNew())
    {
      return '';
    }

    if ($action == 'edit') return "{type: 'delete_object', msg: '".__($params['confirm'])."', link: '".url_for($this->getUrlForAction('delete', $module), $object)."', execute: 'this.deleteObject'},"."\n";
    else return "{type: 'delete_object', msg: '".__($params['confirm'])."', link: '".url_for($this->getUrlForAction('delete', $module), $object)._get_json_data_token()."', execute: 'this.deleteObject'},"."\n";
  }

  public function mooJsonDataToEditObject($object, $params)
  {
    $<?php echo $this->params['route_prefix'] ?> = $object;
    if (isset($params['ajax_request'])) {
      return "{type: 'ajax_link', link: '".url_for($this->getUrlForAction('edit'), $object)."', update: '_new', node_insert: 'content', execute: 'renderAjax'},\n";
    }

    else if (isset($params['inWinPopUp'])) {
      return "{type: 'ajax_link', link: '".url_for($this->getUrlForAction('edit'), $object)."', link_content: '".url_for('<?php echo $this->getModuleName() ?>/editWinContent?<?php echo $this->getPrimaryKeyUrlParams() ?>)."', update: '_new', execute: 'renderAjaxEditWin'},\n";
    }
    else {
        return "{type: 'Guarda ACA !!'}";
    };
  }


  public function mooJsonDataToListObjects($object, $params)
  {
    $<?php echo $this->params['route_prefix'] ?> = $object;
    if (isset($params['ajax_request'])) {
      return "{type: 'ajax_link', link: '".url_for($this->getUrlForAction('edit'), $object)."', update: '_new', node_insert: 'content', execute: 'renderAjax'},\n";
    }

    else if (isset($params['inWinPopUp'])) {
      return "{type: 'ajax_link', link: '".url_for('<?php echo $this->getModuleName() ?>')."', link_content: '".url_for('<?php echo $this->getModuleName() ?>/editWinContent?<?php echo $this->getPrimaryKeyUrlParams() ?>)."', update: '_new', execute: 'renderAjaxListWin'},\n";
    }
    else {
        return "{type: 'Guarda ACA !!'}";
    };
  }


  // Helpers para acciones de objetos en formato JSON - edit
  public function mooJsonDataToWinCancel($params) {
    return "{type: 'cancel', execute: 'this.hideAndDestroy'},";
  }

  public function mooJsonDataToSave($object, $params)
  {
    return "{type: 'ajax_link', action: 'save', link: '".url_for($this->getUrlForAction('edit'), $object)."', execute: 'this.save'},\n";
  }

  public function mooJsonDataToNew($params, $cssClass='btn_admin_actions')
  {
    if (isset($params['inWinPopUp'])) {
      return "{type: 'ajax_link', link: '".url_for($this->getUrlForAction('new'))."', update: '_new', node_insert: 'embedded_win-<?php echo $this->getModuleName() ?>', execute: 'renderAjaxNewWin'},\n";
    }
    else {
    };
  }

  public function mooJsonDataFlashToCloseAndRefresh()
  {
    return "{type: 'close_and_refresh', node_to_refresh: 'parent'},\n";
  }

  public function mooJsonDataFlashToClose()
  {
    return "{type: 'close'},\n";
  }
  
  public function mooJsonDataFlash2ReEditANew($object)
  {
    $<?php echo $this->params['route_prefix'] ?> = $object;
    return "{type: 'close_and_reedit', link: '".url_for($this->getUrlForAction('edit'), $object)."', link_content: '".url_for('<?php echo $this->getModuleName() ?>/editWinContent?<?php echo $this->getPrimaryKeyUrlParams() ?>)."'},\n";
  }
}