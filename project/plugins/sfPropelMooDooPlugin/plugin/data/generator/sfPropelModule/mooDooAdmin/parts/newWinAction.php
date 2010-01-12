  public function executeNewWin(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->form = $this->configuration->getForm();
    $this-><?php echo $this->getSingularName() ?> = $this->form->getObject();

  }
