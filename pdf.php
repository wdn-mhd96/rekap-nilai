<?php 
require 'pdf/fpdf.php';
require_once 'function.php';
$sheetsId = $_GET['id'];
$judul = $_GET['judul'];
$scriptId = 'AKfycbzDSIAjtnU8nUngQK0Nd5DSEJ47woJk2ccJpz2Yh2MET74j_HDcQ4zHut1P5aLNM7UF7A';
$endPointUrl = "https://script.google.com/macros/s/".$scriptId."/exec?id=".$sheetsId;
$response = @file_get_contents($endPointUrl);
$data = json_decode($response, true);
$sum = 0;
foreach ($data as $ent) {
    $b = (float)$ent['Score'];
    $sum += $b;
}
$score = (array_column($data,'Score')) ? array_column($data,'Score') : array(0) ; 
$count = count($score);
$avg = $sum/$count;

$avgg =  number_format((float)$avg,2,'.','');
$max =  max($score);
$min = min($score);
$lulus = 0;
$tidakLulus = 0;

foreach ($data as $item) {
    ($item['Score'] > 56) ? $lulus++ : $tidakLulus++ ;
}                 
class PDF extends FPDF
{
    public $data;
    function Header()
    {
        if ($this->data !== null && count($this->data) > 0) {
        $header = array_keys($this->data[0]);
        $sel_columns = array('Score','Nama Lengkap','Prodi', 'NIM');
        $this->SetLeftMargin(15);
        $this->SetRightMargin(45);
        $this->setFont('Times', 'B', 12); 
        $this->SetFillColor(150, 150, 150);
        $this->Cell(20, 10, 'No', 1, 0, 'C', true);
        $width = array(20, 80, 40, 40, 20);
        foreach($header as $col) {
            if(in_array($col, $sel_columns))
            {
                $key = array_search($col, $sel_columns);
                if($key !== null)
                {
                    $this->Cell($width[$key], 10, $col, 1, 0, 'C', true);
                }
            }
                
        }
        $this->Cell(40, 10, 'Keterangan', 1, 0, 'C', true);
        $this->Ln();
        }
    }

    function BasicTable($header, $data, $columns)
    {
        $i = 1;
        $ket ="";
        $this->SetLeftMargin(15);
        $this->SetRightMargin(45);
        $this->setFont('Times', 'B', 12); 
        $this->SetFillColor(150, 150, 150);
        $this->Cell(20, 7, 'No', 1, 0, 'C', true);
        // $this->Cell(40, 7, 'Score', 1, 0, 'C');
        // $this->Cell(40, 7, 'Nama Lengkap', 1, 0, 'C');
        // $this->Cell(40, 7, 'Nim', 1, 0, 'C');
        $width = array(20, 80, 40, 40, 20);
        foreach ($header as $col) {
            if (in_array($col, $columns)) {
                $key = array_search($col, $columns);
                $this->Cell($width[$key], 7, $col, 1, 0, 'C', true);
            }
        }
        $this->Cell(40, 7, 'Keterangan', 1, 0, 'C', true);
        $this->Ln();
        
        foreach($data as $row) {
            $this->setFont('Times', '', 12); 
            $ket = ($row['Score'] > 56) ? "Lulus" : "Tidak Lulus";
            if ($row['Score'] > 56) {
                $this->SetFillColor(255, 255, 255);
            } else {
                $this->SetFillColor(255, 100, 100);
            }
            $this->Cell(20, 6, $i, 1, 0, 'C', true);
 
            foreach($row as $key => $col) {
                if(in_array($key, $columns)) {
                    $w = array_search($key, $columns);
                $this->Cell($width[$w], 6, $col, 1, 0, 'C', true);
                }
            }
            $this->Cell(40, 6, $ket, 1, 0, 'C', true);
            $this->Ln();
            $i++;
        }
    }
}
$pdf = new PDF('L','mm','A4');
$pdf->addPage();
$pdf->setFont('Times', 'B', 18);
$pdf->cell(295,10, $judul,0,1, 'C');
$pdf->setFont('Times', '', 12);
$pdf->data = $data;
$header = array_keys($data[0]);
$sel_columns = array('Score','Nama Lengkap', 'Prodi','NIM','Tingkat');
$pdf->BasicTable($header, $data, $sel_columns);
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->setFont('Times', 'B', 12);
$pdf->cell(100,10, $judul,0,1);
$pdf->setFont('Times', '', 12);
$pdf->cell(40,10, 'Rata-Rata');
$pdf->cell(5,10, ':');
$pdf->cell(40,10,$avgg);
$pdf->Ln(6);
$pdf->cell(40,10, 'Nilai Tertinggi');
$pdf->cell(5,10, ':');
$pdf->cell(40,10,$max);
$pdf->Ln(6);
$pdf->cell(40,10, 'Nilai Terendah');
$pdf->cell(5,10, ':');
$pdf->cell(40,10,$min);
$pdf->Ln(6);
$pdf->cell(40,10, 'Jumlah Lulus');
$pdf->cell(5,10, ':');
$pdf->cell(40,10,$lulus);
$pdf->Ln(6);
$pdf->cell(40,10, 'Jumlah Tidak Lulus ');
$pdf->cell(5,10, ':');
$pdf->cell(40,10,$tidakLulus);
$pdf->output();

