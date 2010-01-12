<?php

/**
 * Evento form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Damian Suarez
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RecalcNowForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'recalcNow'    => new sfWidgetFormInputHidden(),
      'id'           => new sfWidgetFormInputHidden()
    ));
  }
}