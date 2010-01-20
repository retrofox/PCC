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
        return $this->renderPartial('<?php echo $this->getModuleName() ?>/win_list_content', array ('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper, 'only_list' => true));
      }
    }

    // Ajax Request ?
    if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->getAttribute('forceAsAjax')==true) {

      // Variables Estaticas
      $this->win = array (
        'nodeId_formMethod'=> 'sf_admin_list_form_method-<?php echo $this->getModuleName() ?>',
        'nodeId_container' => 'sf_admin_container-index-<?php echo $this->getModuleName() ?>',
        'nodeId_winsEmbedded'=> 'embedded_win-<?php echo $this->getModuleName() ?>',
        'obj_parent' => 'this'
      );

      $this->controller = array (
        'moduleName' => '<?php echo $this->getModuleName() ?>',
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