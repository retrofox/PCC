<?php

require_once(dirname(__FILE__).'/../lib/BaseCompraGeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/BaseCompraGeneratorHelper.class.php');

/**
 * compra actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage compra
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 12493 2008-10-31 14:43:26Z fabien $
 */
class autoCompraActions extends sfActions
{

  
  public function preExecute()
  {
    $this->configuration = new compraGeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new compraGeneratorHelper();
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
        return $this->renderPartial('compra/win_list_content', array ('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper, 'only_list' => true));
      }
    }

    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->getAttribute('forceAsAjax')==true) {

      // Variables Estaticas
      $this->win = array (
        'nodeId_formMethod'=> 'sf_admin_list_form_method-compra',
        'nodeId_container' => 'sf_admin_container-index-compra',
        'nodeId_winsEmbedded'=> 'embedded_win-compra',
        'obj_parent' => 'this'
      );

      $this->controller = array (
        'moduleName' => 'compra',
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
        $this->redirect('@compra?only_list=true');
      }
      else {
        $this->redirect('@compra');
      }
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      
      if ($this->getRequest()->isXmlHttpRequest()) {
        $this->redirect('@compra?only_list=true');
      }
      else {
        $this->redirect('@compra');
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
    $this->compra = $this->form->getObject();

    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest()) {
      $this->setTemplate('newWin');
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->compra = $this->form->getObject();

    $this->processForm($request, $this->form);

    //$this->setTemplate('new');
    if ($this->getRequest()->isXmlHttpRequest()) $this->setTemplate('newWinContent');
  }

  public function executeEdit(sfWebRequest $request)
  {

    $this->compra = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->compra);

    $this->winEdit = array (
      'win' => 'edit_win-compra-'.$this->compra->getId()
    );

    $this->winEdit_controller = array (
      'moduleName' => 'compra',
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
    $this->compra = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->compra);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->compra = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->compra);

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
    return $this->renderPartial('compra/data_json-delete');
  }
  else $this->redirect('@compra');
}
  public function executeMooDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@compra');
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@compra');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@compra');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorPropelChoiceMany(array('model' => 'Compra'));
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

    $this->redirect('@compra');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $criteria = new Criteria(CompraPeer::DATABASE_NAME);
    $criteria->add('compra.ID', $ids, Criteria::IN);

    $count = CompraPeer::doDelete($criteria);

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
    }

    $this->redirect('@compra');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    if ($form->getObject()->isNew()) $this->getUser()->setFlash('isNew', true);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice-compra-edit', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');
      $compra = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $compra)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          $this->redirect('compra/newWin');
        }
          else $this->redirect('@compra_new');
        }
      else
      {
        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          // Redireccionamos a la accion edit.
          $this->redirect('@compra_edit?id='.$compra->getId().'&isCommingEdit=true');
        }
        else $this->redirect('@compra_edit?id='.$compra->getId());
      }
    }
    else
    {
      $this->getUser()->setFlash('error-compra-edit', 'The item has not been saved due to some errors.');
    }
  }
  protected function getFilters()
  {
    return $this->getUser()->getAttribute('compra.filters', $this->configuration->getFilterDefaults(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('compra.filters', $filters, 'admin_module');
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('Compra');
    $pager->setCriteria($this->buildCriteria());
    $pager->setPage($this->getPage());
    $pager->setPeerMethod($this->configuration->getPeerMethod());
    $pager->setPeerCountMethod($this->configuration->getPeerCountMethod());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('compra.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('compra.page', 1, 'admin_module');
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
    $column = CompraPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
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
    if (!is_null($sort = $this->getUser()->getAttribute('compra.sort', null, 'admin_module')))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('compra.sort', null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('compra.sort', $sort, 'admin_module');
  }
}
