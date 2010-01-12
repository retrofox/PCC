<?php

class ProveedorPeer extends BaseProveedorPeer
{
     public static function retrieveTransportistas(){
         $c = new Criteria();
         $c->addJoin (ProveedorRubroPeer::ID, ProveedorPeer::RUBRO_ID);
         $c->add(ProveedorRubroPeer::NOMBRE, 'Transportista' );
         return ProveedorPeer::doSelect($c);
     }
}
