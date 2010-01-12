<?php
class sfMooDooTCPDF extends sfTCPDF
{
    public function setHeaderData($ln='', $lw=0, $ht='', $hs='', $hst='', $hn='', $hr='', $hf='') {
			$this->header_logo = $ln;
			$this->header_logo_width = $lw;
			$this->header_title = $ht;
            $this->header_subtitle = $hst;
			$this->header_string = $hs;
            $this->header_numero = $hn;
            $this->header_revision = $hr;
            $this->header_fecha = $hf;
		}
    public function getHeaderData() {
			$ret = array();
			$ret['logo'] = $this->header_logo;
			$ret['logo_width'] = $this->header_logo_width;
			$ret['title'] = $this->header_title;
            $ret['subtitle'] = $this->header_subtitle;
			$ret['string'] = $this->header_string;
            $ret['numero'] = $this->header_numero;
            $ret['revision'] = $this->header_revision;
            $ret['fecha'] = $this->header_fecha;

			return $ret;
		}
    public function Header() {

        $headerdata = $this->getHeaderData();
        
        $this->MultiCell(50, 15, ($this->Image(K_PATH_IMAGES.$headerdata['logo'], 24, 5 )), 'LRT', 'L', 0, 2, '', '', true);
        // Set font
        $this->SetFont('times', 'N', 7);
        $this->MultiCell(50, 15, $headerdata['string'], 'LRB', 'C', 0, 0, 15, 20, true);
        $this->SetFont('times', 'B', 16);
        $this->MultiCell(90, 15, $headerdata['title'], 1, 'C', 0, 2, 65, 5, true);
        $this->SetFont('times', 'B', 14);
        $this->MultiCell(90, 15, $headerdata['subtitle'], 1, 'C', 0, 0, 65, 20, true);
        $this->SetFont('times', 'N', 10);
        $this->MultiCell(40, 10, $headerdata['numero'], 1, 'C', 0, 2, 155, 5, true);
        $this->MultiCell(40, 10, $headerdata['revision'], 1, 'C', 0, 2, 155, 15, true);
        $this->MultiCell(40, 10, $headerdata['fecha'], 1, 'C', 0, 1, 155, 25, true);

        // Line break
        $this->Ln(20);
    }

    // Page footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'N', 8);
        // Page number
        $this->Cell(0, 10, 'Pág.: '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, 0, 'R');
    }
  
}

