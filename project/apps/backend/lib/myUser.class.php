<?php
/**
 * myUser
 * Clase del core de symfony para el manejo de sesiones de usuario.
 * Inicialmente esta clase estaba heredada de sfBasicSecurityUser ...
 * pero luego fue modificada y ahora es heredada de sfGuardSecurityUser (del plugin sfGuardPlugin).
 * 
 * @author retrofox
 * 
 * @package symfony
 * @subpackage sfUser
 */

class myUser extends sfGuardSecurityUser
{
}
