public function executeDelete(sfWebRequest $request)
{
  $request->checkCSRFProtection();

  $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
  $this->getRoute()->getObject()->delete();
  $this->getUser()->setFlash('notice-compra-edit', 'The item was deleted successfully.');

  // Modificamos comportamiento si es AJAX
  if ($this->getRequest()->isXmlHttpRequest()) {
    return $this->renderPartial('<?php echo $this->getModuleName() ?>/data_json-delete');
  }
  else $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
}