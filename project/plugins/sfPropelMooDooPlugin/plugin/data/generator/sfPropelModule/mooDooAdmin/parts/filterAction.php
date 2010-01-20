  public function executeFilter(sfWebRequest $request)
  {
    if ($request->hasParameter('_reset'))
    {
      $this->setFilters(array());

      if ($this->getRequest()->isXmlHttpRequest()) {
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>?only_list=true');
      }
      else {
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
      }
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      
      if ($this->getRequest()->isXmlHttpRequest()) {
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>?only_list=true');
      }
      else {
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
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