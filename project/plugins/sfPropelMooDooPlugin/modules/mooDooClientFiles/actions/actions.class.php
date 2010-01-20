<?php

/**
 * mooDooClientFiles actions.
 *
 * @package    pcc
 * @subpackage mooDooClientFiles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mooDooClientFilesActions extends sfActions {

  public function executeLoadJs ($request) {
    $this->setLayout(false);
    $this->getResponse()->setContent('text/javascript');
    $this->setTemplate($request->getParameter('filename'));
    return ".js".chr(0);
  }


  public function executePropelChoiceWithAdd (sfWebRequest $request) {
    $this->select2Add = new ProductoCategoria();
    $this->select2Add->setNombre($request->getParameter('value'));
    $this->select2Add->save();

    $this->options = ProductoCategoriaPeer::doSelect(new Criteria());

    return $this->renderPartial('mooDooClientFiles/selectUpdated');
  }
}
