<?php

/**
 * Proveedor form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ProveedorForm extends BaseProveedorForm {
  public function configure() {
  // Agregamos metodo para agregar rubro para el widget mooWidgetFormPropelChoiceWithAdd
    $this->widgetSchema['rubro_id'] = new mooWidgetFormPropelChoiceWithAdd(array(
        'model' => 'ProveedorRubro',
        'order_by' => array ('Nombre', 'asc'),
        'action2Add' => 'proveedor/createRubro',
        'add_empty' => true
    ));

    $this->widgetSchema['localidad_id'] = new sfWidgetFormPropelChoice(array(
        'model' => 'Localidad',
        'add_empty' => true,
        'order_by' => array ('Nombre', 'asc')
    ));

    $this->widgetSchema['provincia_id'] = new sfWidgetFormPropelChoice(array(
        'model' => 'Provincia',
        'add_empty' => true,
        'order_by' => array ('Nombre', 'asc')
    ));
  }
}
