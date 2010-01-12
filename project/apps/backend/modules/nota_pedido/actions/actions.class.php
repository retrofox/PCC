<?php

require_once dirname(__FILE__).'/../lib/nota_pedidoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/nota_pedidoGeneratorHelper.class.php';

/**
 * nota_pedido actions.
 *
 * @package    pcc
 * @subpackage nota_pedido
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

class nota_pedidoActions extends autoNota_pedidoActions {

  /* Agregar compras a la nota de pedido */
  public function executeListAdminCompras (sfWebRequest $request) {

    $this->nota_pedido = NotaPedidoPeer::retrieveByPK($request->getParameter('id'));
    $this->form = $this->configuration->getForm($this->nota_pedido);

    $this->getRequest()->setParameter('nota_pedido_id', $request->getParameter('id'));
    $this->setTemplate('adminCompras');
  }

  public function executeListAdminComprasContent (sfWebRequest $request) {
    $this->nota_pedido = NotaPedidoPeer::retrieveByPK($request->getParameter('id'));
    $this->form = $this->configuration->getForm($this->nota_pedido);

    $this->getRequest()->setParameter('nota_pedido_id', $request->getParameter('id'));

    return $this->renderPartial('nota_pedido/adminComprasContainer');
  }

  public function executeAgregarCompra (sfWebRequest $request) {
    $this->forward('compra', 'new');
  }

  public function executeListCompras (sfWebRequest $request) {
    $this->forward('compra', 'index');
  }

  public function executeListComprasContent (sfWebRequest $request) {
    $request->setParameter('win_container', true);
    $this->forward('compra', 'index');
  }

  public function executeListProductos (sfWebRequest $request) {
    $this->forward('producto', 'index');
  }

  public function executeListPrint (sfWebRequest $request) {
    $this->forward('nota_pedido', 'print');
  }
  public function executePrint(sfWebRequest $request) {
    $this->nota_pedido = NotaPedidoPeer::retrieveByPK($request->getParameter('id'));

    //cofiguración del pdf
    $config = sfTCPDFPluginConfigHandler::loadConfig('nota-pedido');
    $l=sfTCPDFPluginConfigHandler::includeLangFile($this->getUser()->getCulture());


    $doc_title    = "Nota de pedido ".$this->nota_pedido->getNumero();
      /*$doc_subject  = "test description";
      $doc_keywords = "test keywords";
      */
    //create new PDF document (document units are set by default to millimeters)
    $pdf = new sfMooDooTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);
    $pdf->SetTitle($doc_title);
    //$pdf->SetSubject($doc_subject);
    //$pdf->SetKeywords($doc_keywords);

    //Acá seteamos la información que se ve en la cabecera (hacerlo por variables)
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'ADMINISTRACIÓN', PDF_HEADER_STRING,'NOTA DE PEDIDO','Nota de Pedido Nº'.$this->nota_pedido->getNumero(),'Revisión: '.$this->nota_pedido->getRevision(),'Fecha: '.$this->nota_pedido->getFecha());

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->setLanguageArray($l); //set language items

    //initialize document
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // output some HTML code
    $pdf->SetFont('times', 'N', 12);
    $pdf->Cell( 0, 8, 'Señor(es): '.$this->nota_pedido->getProveedor() ,'LTR', 1,'L');
    $pdf->Cell( 0, 8, 'Domicilio: '.$this->nota_pedido->getProveedor()->getDomicilio(), 'LTR', 1, 'L');
    $pdf->Cell( 0, 8, 'CUIT: '.$this->nota_pedido->getProveedor()->getCUIT(), 'LTR', 1, 'L');
    $pdf->Cell( 0, 8, 'Tel / Fax: '.$this->nota_pedido->getProveedor()->getTelefono().' / '.$this->nota_pedido->getProveedor()->getFax(), 'LTBR', 1, 'L');
    //Close and output PDF document
    $pdf->ln();
    $w = array(15, 15, 20, 70,30,30);
    $pdf->SetFillColor(200, 200, 200);
    $pdf-> MultiCell( $w[0], 5,'Ítem', 1, 'C', 1, 0 );
    $pdf-> MultiCell( $w[1], 5,'Cant.', 1, 'C', 1, 0 );
    $pdf-> MultiCell( $w[2], 5,'Unidad', 1, 'C', 1, 0 );
    $pdf-> MultiCell( $w[3], 5,'Descripción', 1, 'C', 1, 0 );
    $pdf-> MultiCell( $w[4], 5,'Unitario', 1, 'C', 1, 0 );
    $pdf-> MultiCell( $w[5], 5,'TOTAL', 1, 'C', 1, 1 );

/*
 * hacer esto dentro de un bucle
 *
 */
    $total=0;
    foreach ($this->nota_pedido->getCompras() as $i => $compra) {
      $pdf-> MultiCell( $w[0], 5,$i+1, 'LBR', 'C', 0, 0 );
      $pdf-> MultiCell( $w[1], 5,$compra->getCantidad(), 'LBR', 'C', 0, 0 );
      $pdf-> MultiCell( $w[2], 5,$compra->getUnidad(), 'LBR', 'C', 0, 0 );
      $pdf-> MultiCell( $w[3], 5,$compra->getProducto(), 'LBR', 'C', 0, 0 );
      $pdf-> MultiCell( $w[4], 5,$compra->getPrecio(), 'LBR', 'C', 0, 0 );
      $pdf-> MultiCell( $w[5], 5,$compra->getTotalxCompra(), 'LBR', 'C', 0, 1 );
      $total+=$compra->getTotalxCompra();
    }
/*******/
    $pdf-> MultiCell( $w[4], 5,'TOTAL', 'LBR', 'C', 0, 0, 135 );
    $pdf-> MultiCell( $w[5], 5,$total, 'LBR', 'C', 0, 1 );

    $pdf->ln();
    $pdf->Cell( 180, 0,'ESTOS PRECIOS SON MAS IVA','B',1,'L');

    $pdf->ln();
    $w2=array(55,125);
    $pdf-> MultiCell( $w2[0], 5,'Plazo de Entrega', 1, 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,$this->nota_pedido->getPlazoEntrega(), 'TRB', 'L', 0, 1 );

    $pdf-> MultiCell( $w2[0], 5,'Envío por Transporte','LBR', 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,$this->nota_pedido->getTransporte(), 'BR', 'L', 0, 1 );

    $pdf-> MultiCell( $w2[0], 5,'Condición de Pago:', 'LBR', 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,$this->nota_pedido->getCondicionPago(), 'BR', 'L', 0, 1 );

    $pdf-> MultiCell( $w2[0], 5,'Lugar de Entrega:', 'LBR', 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,$this->nota_pedido->getCondicionLugarEntrega(), 'BR', 'L', 0, 1 );
    
    $pdf-> MultiCell( $w2[0], 5,'Remitir Documentación a:', 'LBR', 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,$this->nota_pedido->getRemitirDocA(), 'BR', 'L', 0, 1 );

    $pdf-> MultiCell( $w2[0], 5,'Documentación a Remitir:', 'LBR', 'L', 0, 0 );
    $pdf-> MultiCell( $w2[1], 5,'Remito proveedor, certificado de Calidad, Factura, Manuales, Ensayos, Certificado de Conformidad, MSDN, Otros', 'LBR', 'L', 0, 1 );

    $pdf->ln();
    $pdf->Cell( 180, 0,'AUTORIZACION:',0,1,'L');

    $pdf->Output('nota_pedidoN.pdf');


    return sfView::NONE;
  }
}
