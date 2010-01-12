<?php

class ProductoUDM extends BaseProductoUDM
{
		/**
		 * Devuelve nombre_de_la_unidad gracias al metodo magico __toString() mediante el metodo $this->getNombre()
		 *
		 * @return string nombre_de_la_unidad
		 */
		public function __toString () {
			return $this->getNombre();
		}
}
