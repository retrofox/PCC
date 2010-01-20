  public function executeEditWinContent(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this-><?php echo $this->getSingularName() ?>);
  }