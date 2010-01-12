<?php

class ProductoCategoria extends BaseProductoCategoria
{
		/**
		 * Devuelve Categoria gracias al metodo magico __toString() mediante el metodo $this->getCategoria()
		 *
		 * @return string Categoria
		 */
		public function __toString () {
			return $this->getNombre();
		}
}
