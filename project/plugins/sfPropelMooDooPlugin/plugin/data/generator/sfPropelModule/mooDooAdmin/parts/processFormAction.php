  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    if ($form->getObject()->isNew()) $this->getUser()->setFlash('isNew', true);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice-<?php echo $this->getModuleName() ?>-edit', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');
      $<?php echo $this->getSingularName() ?> = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $<?php echo $this->getSingularName() ?>)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          $this->redirect('<?php echo $this->getModuleName() ?>/newWin');
        }
          else $this->redirect('@<?php echo $this->getUrlForAction('new') ?>');
        }
      else
      {
        // Modificamos comportamiento si es AJAX
        if ($this->getRequest()->isXmlHttpRequest())
        {
          // Redireccionamos a la accion edit.
          $this->redirect('@<?php echo $this->getUrlForAction('edit') ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>.'&isCommingEdit=true');
        }
        else $this->redirect('@<?php echo $this->getUrlForAction('edit') ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>);
      }
    }
    else
    {
      $this->getUser()->setFlash('error-<?php echo $this->getModuleName() ?>-edit', 'The item has not been saved due to some errors.');
    }
  }