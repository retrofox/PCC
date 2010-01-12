<?php

class UserProfile extends BaseUserProfile {
/**
 * Devuelve Nombre Completo gracias al metodo magico __toString() mediante el metodo $this->getNombreApellido()
 *
 * @return string Nombre Completo
 */
  public function __toString () {
    return $this->getNombreApellido();
  }
  /**
   * Develve el nombre completo de la forma nombre + apellido del perfil de un usuario
   *
   * @author retrofox
   * @date 01/01/2009
   *
   * @params   ( )
   * @return string Nombre completo
   */
  public function getNombreApellido () {
    $NombreApellido = $this->getNombre().' '.$this->getApellido();
    if ($this->getNombre()=='' && $this->getApellido() == '') $NombreApellido = 'No definido.';

    return $NombreApellido;
  }

  /**
   * Develve el nombre completo de la foma apellido + nombre del perfil de un usuario
   *
   * @author retrofox
   * @date 01/01/2009
   *
   * @params   ( )
   * @return string Nombre completo
   */
  public function getApellidoNombre () {
    $ApellidoNombre = $this->getApellido().', '.$this->getNombre();
    if ($this->getNombre()=='' && $this->getApellido() == '') $ApellidoNombre = 'No definido.';

    return $ApellidoNombre;
  }
}
