<?php

/**
 * Evento form.
 *
 * @package    pcc
 * @subpackage form
 * @author     Damian Suarez
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EventoForm extends BaseEventoForm {
  public function configure() {
    unset(
        $this['user_id']
    );

    $this->widgetSchema->setHelp ('operacion', 'Esta operación define si el evento produce un incremento o decremento en el stock del producto');

    // Definimos la 'operacion' como un select
    $this->widgetSchema['operacion'] = new sfWidgetFormChoice(array(
        'choices' => EventoPeer::$operacionChoices,
        'expanded' => true,
        'multiple' => false
    ));

    $this->setDefault ('fecha', date('Y-m-d H:i', time()));

    $this->validatorSchema['cantidad']->setOption ('required', true);
    $this->validatorSchema['operacion']->setOption ('required', true);
  }
}
