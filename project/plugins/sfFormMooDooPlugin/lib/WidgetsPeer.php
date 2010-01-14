<?php

class WidgetsPeer
{
  // retrieve a resultset to decorate in sfWidgetFormMooPropelChoiceWithAdd
  public static function retrieveOptionsToSelect ($id, $field, $table) {

    $conexion= Propel::getConnection();
    $sql = sprintf('SELECT %s, %s FROM %s',
        $id, $field, $table
    );

    $query = $conexion->prepare($sql);
    $query->execute();

    $resultset = $query->fetchAll(PDO::FETCH_ASSOC);

    return !empty($resultset) ? $resultset : null;
  }
}
