<?php

/**
 * formMooDoo actions.
 *
 * @package    pcc
 * @subpackage formMooDoo
 * @author     Damian Suarez
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class formMooDooComponents extends sfComponents {

    // sfWidgetFormMooPropelChoiceWithAdd
    public function executePropelChoiceWithAdd(sfWebRequest $request) {
      $this->getResponse()->setContentType('text/html');

      //$this->select_elements = ProductoUDMPeer::retrieveUDMs();
      $this->select_elements = WidgetsPeer::retrieveOptionsToSelect(
        $this->db_search['field_id'],
        $this->db_search['field_name'],
        $this->db_search['table_name']
      );

    }
}