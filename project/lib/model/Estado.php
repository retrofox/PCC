<?php

class Estado extends BaseEstado
{
    public function __toString() {
        return $this->getNombre();
    }
}
