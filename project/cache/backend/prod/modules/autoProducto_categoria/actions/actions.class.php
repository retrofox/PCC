<?php

require_once(dirname(__FILE__).'/../lib/BaseProducto_categoriaGeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/BaseProducto_categoriaGeneratorHelper.class.php');

/**
 * producto_categoria actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage producto_categoria
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 12493 2008-10-31 14:43:26Z fabien $
 */
class autoProducto_categoriaActions extends sfActions
{

  
  public function preExecute()
  {
    $this->configuration = new producto_categoriaGeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new producto_categoriaGeneratorHelper();
  }

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->jsonData4Win = array (
      'controller' => array (
        'moduleName' => 'compras'
      )
    );

    // Only List ?
    if ($request->hasParameter('only_list')) {
      if ($request->getParameter('only_list')) {
        return $this->renderPartial('producto_categoria/win_list_content', array ('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper, 'only_list' => true));
      }
    }

    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->getAttribute('forceAsAjax')==true) {

      // Variables Estaticas
      $this->win = array (
        'nodeId_formMethod'=> 'sf_admin_list_form_method-producto_categoria',
        'nodeId_container' => 'sf_admin_container-index-producto_categoria',
        'nodeId_winsEmbedded'=> 'embedded_win-producto_categoria',
        'obj_parent' => 'this'
      );

      $this->controller = array (
        'moduleName' => 'producto_categoria',
        'action' => 'list'
      );

      $this->dims = array (
        'width' => 800,
        'left' => 100,
        'top' => 100
      );

      $this->jsonData4Win = array (
        controller => $this->controller,
        win => $this->win,
        dims => $this->dims
      );

      if ($request->getParameter('win_container')) {
        $this->setTemplate('indexWinContent');
      }
      else {
        $this->setTemplate('indexWin');
      };
    }
  }
  public function executeFilter(sfWebRequest $request)
  {
    if ($request->hasParameter('_reset'))
    {
      $this->setFilters(array());

      if ($this->getRequest()->isXmlHttpRequest()) {
        $this->redirect('@producto_categoria?only_list=true');
      }
      else {
        $this->redirect('@producto_categoria');
      }
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      
      if ($this->getRequest()->isXmlHttpRequest()) {
        $this->redirect('@producto_categoria?only_list=true');
      }
      else {
        $this->redirect('@producto_categoria');
      }
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($this->getRequest()->isXmlHttpRequest()) {
      $this->setTemplate('indexWin');
    }
    else {
      $this->setTemplate('index');
    }
  }
  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->producto_categoria = $this->form->getObject();

    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest()) {
      $this->setTemplate('newWin');
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->producto_categoria = $this->form->getObject();

    $this->processForm($request, $this->form);

    //$this->setTemplate('new');
    if ($this->getRequest()->isXmlHttpRequest()) $this->setTemplate('newWinContent');
  }

  public function executeEdit(sfWebRequest $request)
  {

    $this->producto_categoria = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->producto_categoria);

    $this->winEdit = array (
      'win' => 'edit_win-producto_categoria-'.$this->producto_categoria->getId()
    );

    $this->winEdit_controller = array (
      'moduleName' => 'producto_categoria',
      'action' => 'edit'
    );

    $this->winEdit_dims = array (
      'width' => 450,
      'left' => 100,
      'top' => 40
    );


    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest()) {
      $this->setTemplate('editWin');

      $this->jsonData4Win = array (
        controller => $this->winEdit_controller,
        win => $this->winEdit,
        dims => $this->winEdit_dims
      );
    }

    // Viene de edicion ?
    if ($request->getParameter('isCommingEdit')=='true') {
      $this->setTemplate('editWinContent');
      $this->setLayout(false);
    }
  }
  public function executeEditWinContent(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->producto_categoria = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->producto_categoria);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->producto_categoria = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->producto_categoria);

    $this->processForm($request, $this->form);

	// Ojo aca ... no se si es lo mejor
    if ($this->getRequest()->isXmlHttpRequest()) $this->setTemplate('editWinContent');
  }

public function executeDelete(sfWebRequest $request)
{
  $request->checkCSRFProtection();

  $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
  $this->getRoute()->getObject()->delete();
  $this->getUser()->setFlash('notice-compra-edit', 'The item was deleted successfully.');

  // Modificamos comportamiento si es AJAX
  if ($this->getRequest()->isXmlHttpRequest()) {
    return $this->renderPartial('producto_categoria/data_json-delete');
  }
  else $this->redirect('@producto_categoria');
}
  public function executeMooDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@producto_categoria');
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@producto_categoria');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@producto_categoria');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorPropelChoiceMany(array('model' => 'ProductoCategoria'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@producto_categoria');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $criteria = new Criteria(ProductoCategoriaPeer::DATABASE_NAME);
    $criteria->add('producto_categoria.ID', $ids, Criteria::IN);

    $count = ProductoCategoriaPeer::doDelete($criteria);

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
    }

    $this->redirect('@producto_categoria');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    if ($form->getObject()->isNew()) $this->getUser()->setFlash('isNew', true);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice-producto_categoria-edit', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');
      $producto_categoria = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $producto_categoria)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          $this->redirect('producto_categoria/newWin');
        }
          else $this->redirect('@producto_categoria_new');
        }
      else
      {
        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          // Redireccionamos a la accion edit.
          $this->redirect('@producto_categoria_edit?id='.$producto_categoria->getId().'&isCommingEdit=true');
        }
        else $this->redirect('@producto_categoria_edit?id='.$producto_categoria->getId());
      }
    }
    else
    {
      $this->getUser()->setFlash('error-producto_categoria-edit', 'The item has not been saved due to some errors.');
    }
  }
  protected function getFilters()
  {
    return $this->getUser()->getAttribute('producto_categoria.filters', $this->configuration->getFilterDefaults(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('producto_categoria.filters', $filters, 'admin_module');
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('ProductoCategoria');
    $pager->setCriteria($this->buildCriteria());
    $pager->setPage($this->getPage());
    $pager->setPeerMethod($this->configuration->getPeerMethod());
    $pager->setPeerCountMethod($this->configuration->getPeerCountMethod());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('producto_categoria.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('producto_categoria.page', 1, 'admin_module');
  }

  protected function buildCriteria()
  {
    if (is_null($this->filters))
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $criteria = $this->filters->buildCriteria($this->getFilters());

    $this->addSortCriteria($criteria);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
    $criteria = $event->getReturnValue();

    return $criteria;
  }

  public function executeLoadJsonData($request) {

      // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();


    $this->setLayout(false);
    $this->getResponse()->setContent('text/javascript');
    $this->setTemplate($request->getParameter('filename'));
    return ".json".chr(0);
  }
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    // camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
    $column = ProductoCategoriaPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
    if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }

  protected function getSort()
  {
    if (!is_null($sort = $this->getUser()->getAttribute('producto_categoria.sort', null, 'admin_module')))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('producto_categoria.sort', null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('producto_categoria.sort', $sort, 'admin_module');
  }
}