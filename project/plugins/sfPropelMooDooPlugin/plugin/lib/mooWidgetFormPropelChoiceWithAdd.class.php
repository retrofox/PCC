<?php

/*
 * Este archivo es parte del grupo de widgets de formularios de mooDoo
 * (c) Damian Suarez <damian.suarez@xifox.net>
 *
 */

/**
 * mooWidgetFormPropelChoiceWithAdd representa un widget de opcionesa partir de un modelo con una opcion de 'add' con ajax. 
 *
 * @package    symfony
 * @subpackage widget
 * @author     Damian Suarez <damian.suarez@xifox.net>
 */
class mooWidgetFormPropelChoiceWithAdd extends  sfWidgetFormPropelChoice {
	
  protected function configure($options = array(), $attributes = array()) {
    $this->addOption('action2Add', 'mooDooClientFiles/propelChoiceWithAdd');
    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $select_tag = parent::render($name, $value, $attributes, $errors);

    $conten_tag = '<div class="select_with_add" id="'.$this->getAttribute('id').'">';

    $conten_tag.= '<div class="win4add2select">';
    $conten_tag.= '<input link_to_add="'.url_for ($this->getOption('action2Add')).'" name="add2select" />';
    $conten_tag.= '<div class="btn-cover"><div class="icn icn-delete"></div></div>';
    $conten_tag.= '<div class="btn-cover"><div class="icn icn-submit"></div></div>';
    $conten_tag.= '</div>';

    $conten_tag.= $select_tag;
    $conten_tag.= '<div class="btn-cover"><div class="icn icn-add btn_add2Select4Win"></div>';
    $conten_tag.= '</div>';
    $conten_tag.= '</div>';
    return $conten_tag;
  }
	
/*
  // Implementas el método configure. Tienes opciones obligatorias y otras opciones no necesarias
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('choices');
    $this->addOption('multiple', false);
  }

  // El método render se llama al incluir el campo en la vista
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    // Para obtener las opciones que se han configurado...
    if ($this->getOption('multiple'))
    {
      $attributes['multiple'] = 'multiple';

      if ('[]' != substr($name, -2))
      {
        $name .= '[]';
      }
    }
    // Igual con las obligatorias
    $choices = $this->getOption('choices');
    ..... haces lo que sea que necesites
    // y finalmente devuelves el código HTML a través de las funciones renderContentTag para etiquetas con contenido (div, span, ...)
    // o renderTag para input, img, etc.
    // El método generateId sirve para a partir del nombre del campo generar el identificador (id)
    return 
      $this->renderContentTag('div', 
        $this->renderTag('input', array_merge(array('type' => 'hidden', 'value' => $val, 'name' => $name, 'id' => $this->generateId("aux_".$name)), $attributes)),
        array('id' => $this->generateId($name)));
  }
*/

}
