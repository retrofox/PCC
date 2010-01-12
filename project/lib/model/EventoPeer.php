<?php

class EventoPeer extends BaseEventoPeer
{
  //Definimos los posibles valores de 'operacion'
  static public $operacionChoices = array(
    0 => 'Decremento',
    1 => 'Incremento'
    );  
}
