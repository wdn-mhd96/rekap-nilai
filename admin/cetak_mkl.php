<?php
require '../pdf/fpdf.php';
require_once '../connection.php';
$tid = $_GET['tid'];
$idk = $_GET['idk'];
$headQ = mysqli_query($connect, "SELECT ttest.*, tkelas.NamaKelas, tmakul.NamaMakul, tperiode.tahun, tperiode.jenis_tes
                         from ttest
                       left join tmakul on tmakul.IdMakul = ttest.makul
                       left join tkelas on tkelas.IdKelas  = ttest.id_kelas
                       left join tperiode on tperiode.id_periode  = ttest.id_periode
                     where id_test = '$tid'");
$head = mysqli_fetch_array($headQ);
$makul = $head['NamaMakul'];
$kelas = $head['NamaKelas'];
$tahun = $head['tahun'];
$jenis = ($head['jenis_tes']=="2") ? "UAS" : "UTS";
$periode = $tahun. " - ". $jenis;
$testQ = mysqli_query($connect, "SELECT ttranskrip_nilai.*, tmakul.NamaMakul,tmahasiswa.NamaMahasiswa
                                from ttranskrip_nilai
                                left join tmakul on ttranskrip_nilai.id_makul = tmakul.IdMakul
                                left join tmahasiswa on ttranskrip_nilai.nim = tmahasiswa.NIM where id_test = '$tid'");

$kelasQ = mysqli_query($connect, "SELECT * from tmahasiswa where IdKelas = '$idk'");
$totalmhs = mysqli_num_rows($kelasQ);
$totalikut = mysqli_num_rows($testQ);
$total = 0;
$tlulus = 0;
$tidak = 0;
$no = 1;
function drawHeader($pdf) {
    $pdf->setFont('Times', 'B', 12);
    $pdf->Cell('10', '7', 'No', 1, 0, 'C');
    $pdf->Cell('30', '7', 'NIM', 1, 0, 'C');
    $pdf->Cell('60', '7', 'Nama Mahasiswa', 1, 0, 'C');
    $pdf->Cell('20', '7', 'Nilai', 1, 0, 'C');
    $pdf->Cell('40', '7', 'Keterangan', 1, 1, 'C');
}
$pdf = new FPDF('P', 'mm','A4');
$pdf->addPage();
$pdf->setFont('Times', 'B', 12);
$pdf->Cell('30','7','Mata Kuliah',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('50','7',$makul,0,1);
$pdf->Cell('30','7','Kelas',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('50','7',$kelas,0,1);
$pdf->Cell('30','7','Periode',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('50','7',$periode,0,1);
$pdf->Ln();
$centerX = ($pdf->GetPageWidth() - 160) / 2;
$pdf->SetX($centerX);
$pdf->setFont('Times', 'B', 12);
$pdf->Cell('10','7', 'No',1,0,'C');
$pdf->Cell('30','7', 'NIM',1,0,'C');
$pdf->Cell('60','7', 'Nama Mahasiswa',1,0,'C');
$pdf->Cell('20','7', 'Nilai',1,0,'C');
$pdf->Cell('40','7', 'Keterangan',1,1,'C');

while($test = mysqli_fetch_array($testQ))
{
    if ($pdf->GetY() + 7 > $pdf->GetPageHeight()) {
        $pdf->addPage();
        $centerX = ($pdf->GetPageWidth() - 160) / 2;
        $pdf->SetX($centerX);
        drawHeader($pdf);
    }
    $centerX = ($pdf->GetPageWidth() - 160) / 2;
    $pdf->SetX($centerX);
    
    $ket = ($test['nilai'] < 56) ? "150,70,77" : "255,255,255";
    $noo = $no++;
    $nim = $test['nim'];
    $nama = $test['NamaMahasiswa'];
    $nilai = $test['nilai'];
    $lulus = ($test['nilai']> 55) ? "Lulus" :"Tidak Lulus";
    ($test['nilai']>55) ? $tlulus++ : $tidak++ ;
    $total += $test['nilai'];
    $pdf->setFont('Times', '', 12);
    $pdf->SetFillColor(intval($ket));
    $pdf->Cell('10','7', $noo,1,0,'C', true);
    $pdf->Cell('30','7', $nim,1,0,'C', true);
    $pdf->Cell('60','7', $nama,1,0,'C', true);
    $pdf->Cell('20','7', $nilai,1,0,'C', true);
    $pdf->Cell('40','7', $lulus,1,1,'C', true);
}
$pdf->Ln();
$tidakikut = $totalmhs - $totalikut;
$avgg = $total/$totalikut;
$avg = number_format($avgg,2,',',0);
$pdf->Cell('50','7','Rata - Rata',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('40','7', $avg,0,1);
$pdf->Cell('50','7','Lulus',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('40','7', $tlulus,0,1);
$pdf->Cell('50','7','Tidak Lulus',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('40','7', $tidak,0,1);
$pdf->Cell('50','7','Yang Mengikuti',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('40','7', $totalikut,0,1);
$pdf->Cell('50','7','Yang tidak mengikuti',0,0);
$pdf->Cell('10','7',':',0,0);
$pdf->Cell('40','7', $tidakikut,0,1);
$pdf->Output();

?>