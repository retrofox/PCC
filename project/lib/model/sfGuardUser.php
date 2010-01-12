<?php

class sfGuardUser extends PluginsfGuardUser {
  public function getNombre() {
    return $this->getProfile()->getNombre();
  }

  public function getApellido() {
    return $this->getProfile()->getApellido();
  }
}
