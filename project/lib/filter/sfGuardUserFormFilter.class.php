<?php

/**
 * sfGuardUser filter form.
 *
 * @package    pcc
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfGuardUserFormFilter.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardUserFormFilter extends BasesfGuardUserFormFilter {
  public function configure() {
    unset($this['algorithm'], $this['salt'], $this['password']);

    $this->widgetSchema['sf_guard_user_group_list']->setLabel('Groups');
    $this->widgetSchema['sf_guard_user_permission_list']->setLabel('Permissions');

    $this->widgetSchema['nombre'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['nombre'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema['apellido'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['apellido'] = new sfValidatorPass(array('required' => false));

  }

  public function getFields() {
    return array_merge(
    array(
    'nombre' => 'Text',
    'apellido' => 'Text'
    ),
    parent::getFields()
    );
  }

  protected function addNombreColumnCriteria(Criteria $criteria, $field, $values) {
    $criteria->addJoin (sfGuardUserPeer::ID, UserProfilePeer::USER_ID);
    $criteria->add(UserProfilePeer::NOMBRE, '%'.$values['text'].'%', Criteria::LIKE);
  }

  protected function addApellidoColumnCriteria(Criteria $criteria, $field, $values) {
    $criteria->addJoin (sfGuardUserPeer::ID, UserProfilePeer::USER_ID);
    $criteria->add(UserProfilePeer::APELLIDO, '%'.$values['text'].'%', Criteria::LIKE);
  }
}
