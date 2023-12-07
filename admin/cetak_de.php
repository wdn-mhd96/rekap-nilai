<?php
include '../connection.php';
include '../pdf/fpdf.php';

if(!isset($_GET['idk']) || !isset($_GET['pid']))
{
    echo "Tidak Ada data Untuk Dicetak";
}
else
{
$idk = $_GET['idk'];
$pid = $_GET['pid'];
$pdf = new FPDF('P', 'mm', 'A4');
$mhsQ = mysqli_query($connect, "SELECT tmahasiswa.*, tkelas.NamaKelas FROM tmahasiswa 
left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas
WHERE tmahasiswa.IdKelas = '$idk'");
$total = mysqli_num_rows($mhsQ);
while ($mhs = mysqli_fetch_array($mhsQ)) {
    $nim = $mhs['NIM'];
    $nama = $mhs['NamaMahasiswa'];
    $kelass = $mhs['NamaKelas'];
    $transQ = mysqli_query($connect,"SELECT ttranskrip_nilai.* , tmakul.NamaMakul
    FROM ttranskrip_nilai left join tmakul on tmakul.IdMakul = ttranskrip_nilai.id_makul
    WHERE id_kelas='$idk' AND id_periode='$pid' AND nim='$nim' AND nilai <56");
    if($transQ !== null and mysqli_num_rows($transQ) > 0) {
    $pdf->AddPage();
    $pdf->setFont('Times', 'B', 18);
    $pdf->cell($pdf->GetPageWidth(),6, 'Rekap Nilai D & E '. $kelass, 0, 1);
    $pdf->Ln(10);
    $pdf->setFont('Times', '', 12);
    $pdf->cell(20, 3, 'NIM', 0, 0);
    $pdf->cell(10, 3, ':', 0, 0);
    $pdf->cell(10, 3, $nim, 0, 0);
    $pdf->Ln(5);
    $pdf->cell(20, 3, 'Nama', 0, 0);
    $pdf->cell(10, 3, ':', 0, 0);
    $pdf->cell(10, 3, $nama, 0, 0);
    $pdf->Ln(10);
    $centerX = ($pdf->GetPageWidth() - 150) / 2;
    $pdf->SetX($centerX);
    $pdf->setFont('Times', 'B', 12);
    $pdf->SetFillColor(180, 180, 180);
    $pdf->cell(10, 7, 'No.', 1, 0, 'C', true);
    $pdf->cell(80, 7, 'Mata Kuliah', 1, 0, 'C', true);
    $pdf->cell(20, 7, 'Nilai', 1, 0, 'C', true);
    $pdf->cell(20, 7, 'Mutu', 1, 0, 'C', true);
    $pdf->cell(20, 7, 'Huruf', 1, 0, 'C', true);
    $pdf->Ln();
    
        $no = 1;
        while($trs = mysqli_fetch_array($transQ)){
            $centerX = ($pdf->GetPageWidth() - 150) / 2;
        $pdf->SetX($centerX);
        $noo = $no++;
        $nilai = $trs['nilai'];
        $makuls = $trs['NamaMakul'];
        $makulss = substr($makuls,0,40);
            if($nilai<=45.5)
            {
                $mutu=0;
                $huruf="E";
            }
            else if($nilai<=55.5)
            {
                $mutu=1;
                $huruf="D";
            }
            elseif($nilai<=61.5)
            {
                $mutu=2;
                $huruf="C";
            }
            elseif($nilai<=64.5)
            {
                $mutu=2.5;
                $huruf="C+";
            }
            elseif($nilai<=68.5)
            {
                $mutu=2.75;
                $huruf="B-";
            }
            elseif($nilai<=72.5)
            {
                $mutu=3;
                $huruf="B";
            }
            elseif($nilai<=75.5)
            {
                $mutu=3.5;
                $huruf="B+";
            }
            elseif($nilai<=78.5)
            {
                $mutu=3.75;
                $huruf="A-";
            }
            else
            {
                $mutu=4;
                $huruf="A";
            }
            $pdf->cell(10, 7, $noo, 1, 0, 'C');
            $pdf->cell(80, 7, $makulss, 1, 0, 'C');
            $pdf->cell(20, 7, $nilai, 1, 0, 'C');
            $pdf->cell(20, 7, $mutu, 1, 0, 'C');
            $pdf->cell(20, 7, $huruf, 1, 0, 'C');
            $pdf->Ln();
        }
    }
} 
    
    
        $pdf->output();
}

?>