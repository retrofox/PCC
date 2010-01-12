<?php

class Pais extends BasePais
{
	/**
	 * Devuelve el nombre del pais gracias al metodo magico __toString()
	 *
	 * @return string Nombre del Pais
	 */
	public function __toString () {
		return $this->getNombre();
	}
}	