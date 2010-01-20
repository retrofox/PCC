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