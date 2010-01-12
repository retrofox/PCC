<?php

class Localidad extends BaseLocalidad
{
	/**
	 * Devuelve el nombre de la localidad gracias al metodo magico __toString()
	 *
	 * @return string Nombre de la Localidad
	 */
	public function __toString () {
		return $this->getNombre();
	}
}
