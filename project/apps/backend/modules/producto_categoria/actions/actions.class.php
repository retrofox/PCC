<?php

require_once dirname(__FILE__).'/../lib/producto_categoriaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/producto_categoriaGeneratorHelper.class.php';

/**
 * producto_categoria actions.
 *
 * @package    pcc
 * @subpackage producto_categoria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class producto_categoriaActions extends autoProducto_categoriaActions {
  public function executeListNew (sfWebRequest $request) {
    $this->forward('producto_categoria', 'newWin');
  }

  public function executeListEdit (sfWebRequest $request) {
    $this->forward('producto_categoria', 'editWin');
  }

  public function executeEditWin (sfWebRequest $request) {
    $this->producto_categoria = ProductoCategoriaPeer::retrieveByPK($request->getParameter('id'));
    $this->form = $this->configuration->getForm($this->producto_categoria);
  }


  // widget sfFormMooDooPropelChoiceWithAdd
  public function executeAddCategoriaAProducto (sfWebRequest $request) {
    $this->ProductoCategoriaForm = new ProductoCategoriaForm();
    if ($request->isMethod('post')) {
      $this->ProductoCategoriaForm->bind($request->getParameter($this->ProductoCategoriaForm->getName()));

      if ($this->ProductoCategoriaForm->isValid()) {
        $this->ProductoCategoriaForm->save();
      }
    }

    return $this->renderComponent('formMooDoo', 'propelChoiceWithAdd', array (
      db_search => array (
          'field_id' => ProductoCategoriaPeer::ID,
          'field_name' => ProductoCategoriaPeer::NOMBRE,
          'table_name' => ProductoCategoriaPeer::TABLE_NAME
        ),
      'id_selected' => $this->ProductoCategoriaForm->getObject()->getId(),
      'form_field' => $this->ProductoCategoriaForm['nombre']
    ));
  }
}
