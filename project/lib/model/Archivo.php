<?php

class Archivo extends BaseArchivo
{
		/**
		 * Devuelve nombre_de_archivo gracias al metodo magico __toString() mediante el metodo $this->getNombre()
		 *
		 * @return string nombre_de_archivo
		 */
		public function __toString () {
			return $this->getNombre();
		}
}
