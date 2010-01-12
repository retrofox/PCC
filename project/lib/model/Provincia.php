<?php
/*
 * clase Provincia
 */
class Provincia extends BaseProvincia
{
	/**
	 * Devuelve el nombre de la provincia gracias al metodo magico __toString()
	 *
	 * @return string Nombre de la Provincia
	 */
	public function __toString () {
		return $this->getNombre();
	}
	
}

