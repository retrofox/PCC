<?php

class Proveedor extends BaseProveedor
{
		/**
		 * Devuelve nombre_de_proveedor gracias al metodo magico __toString() mediante el metodo $this->getNombre()
		 *
		 * @return string nombre_de_proveedor
		 */
		public function __toString () {
			return $this->getNombre();
		}

        public function getDomicilio () {
            return $this->getDireccionCalle().' '.$this->getDireccionNumero().' '.$this->getDireccionManzana().' '.$this->getDireccionBarrio().' '.$this->getDireccionPiso().' '.$this->getDireccionDepto().' '.$this->getLocalidad().' '.$this->getProvincia() ;
        }
}
