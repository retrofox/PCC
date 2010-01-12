<?php

require_once dirname(__FILE__).'/../lib/proveedorGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/proveedorGeneratorHelper.class.php';

/**
 * proveedor actions.
 *
 * @package    pcc
 * @subpackage proveedor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class proveedorActions extends autoProveedorActions {


// Agregamos metodo para agregar rubro para el widget mooWidgetFormPropelChoiceWithAdd
  public function executeCreateRubro (sfWebRequest $request) {
    $this->select2Add = new ProveedorRubro();
    $this->select2Add->setNombre($request->getParameter('value'));
    $this->select2Add->save();

    $this->options = ProveedorRubroPeer::doSelect(new Criteria());

    return $this->renderPartial('global/selectUpdated');
  }
}
