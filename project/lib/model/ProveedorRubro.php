<?php

class ProveedorRubro extends BaseProveedorRubro
{
		/**
		 * Devuelve nombre del proveedor gracias al metodo magico __toString() mediante el metodo $this->getNombre()
		 *
		 * @return string nombre del proveedor
		 */
		public function __toString () {
			return $this->getNombre();
		}
}
