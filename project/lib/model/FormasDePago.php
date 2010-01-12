<?php

class FormasDePago extends BaseFormasDePago
{
    public function __toString() {
        return $this->getNombre();
    }
}
