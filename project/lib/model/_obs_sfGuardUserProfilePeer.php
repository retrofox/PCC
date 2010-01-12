<?php

class sfGuardUserProfilePeer extends BasesfGuardUserProfilePeer
{
  //Definimos posibles valores en los tipos de documentos
  static public $dniTipo = array(
    0 => 'DNI',
    1 => 'LE',
    2 => 'Otro'
  );  
}
