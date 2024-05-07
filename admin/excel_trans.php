<?php
require '../connection.php';
if(!isset($_GET['idk']) && !isset($_GET['pid']))
{
    echo "Tidak Ada Menu Dipilih";
    return;
}

$idk = $_GET['idk'];
$pid = $_GET['pid'];
$ta = $_GET['taid'];
$jn = $_GET['jn'];

if($jn==2)
{
$testQ = mysqli_query($connect, "SELECT ttest.*, tmakul.NamaMakul,tkelas.NamaKelas, ttahun.nama_ta
 from ttest
 left join tmakul on tmakul.IdMakul = ttest.makul
 left join tkelas on tkelas.IdKelas = ttest.id_kelas
 left join ttahun on ttahun.id_ta = ttest.id_ta 
 where ttest.id_kelas ='$idk' and ttest.id_ta = '$ta' and ttest.status=1");
}
else
{
    $testQ = mysqli_query($connect, "SELECT ttest.*, tmakul.NamaMakul,tkelas.NamaKelas, ttahun.nama_ta
 from ttest
 left join tmakul on tmakul.IdMakul = ttest.makul
 left join tkelas on tkelas.IdKelas = ttest.id_kelas
 left join ttahun on ttahun.id_ta = ttest.id_ta 
 where ttest.id_kelas ='$idk' and ttest.id_ta = '$ta' and ttest.status_uts=1");
}
 $test = mysqli_fetch_array($testQ);

$kelas = $test['NamaKelas'];
$prdthn = $test['nama_ta'];
$jenis = ($jn=="2") ? "UAS" :"UTS";
$periode = $prdthn." - ".$jenis;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=rekap nilai $kelas.xls");
$mhsQ = mysqli_query($connect,"SELECT * from tmahasiswa where IdKelas = '$idk'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Rekap Nilai <?= $kelas ?></h3>
    <h6>Periode = <?= $periode?></h6>

    <table border="1">
        <thead>
            <th>No.</th>
            <th>Nama</th>
            <th>Nim</th>
            <?php
            mysqli_data_seek($testQ,0);
            while($testt = mysqli_fetch_array($testQ))
            {
                echo "
                    <th>$testt[NamaMakul]</th>
                    <th>Nilai</th>
                    <th>Mutu</th>
                ";
            }
            
            ?>
        </thead>
        <tbody>
            <?php
            $no=1;
            while($mhs=mysqli_fetch_array($mhsQ))
            {
                $nim = $mhs['NIM'];
                $noo = $no++;
                $konten = "
                    <tr>
                        <td>$noo</td>
                        <td>$mhs[NamaMahasiswa]</td>
                        <td>$mhs[NIM]</td>
                ";
                mysqli_data_seek($testQ,0);
                while($testtt = mysqli_fetch_array($testQ))
                {
                    $idt= $testtt['id_test'];
                    if($jn==2)
                    {
                        $transQ = mysqli_query($connect,"SELECT * from ttranskrip_nilai where id_test='$idt' and nim='$nim' and jenis='2'");
                    }
                    else
                    {
                        $transQ = mysqli_query($connect,"SELECT * from ttranskrip_nilai where id_test='$idt' and nim='$nim' and jenis='1'");
                    }
                    while($trans=mysqli_fetch_array($transQ))
                    {
                        $nilai = $trans['nilai'];
                        if($nilai<=45.5)
                        {
                            $mutu=0;
                            $huruf="E";
                            $background="background:red";
                        }
                        else if($nilai<=55.5)
                        {
                            $mutu=1;
                            $huruf="D";
                            $background="background:orange";
                        }
                        elseif($nilai<=61.5)
                        {
                            $mutu=2;
                            $huruf="C";
                            $background="background:yellow";
                        }
                        elseif($nilai<=64.5)
                        {
                            $mutu=2.5;
                            $huruf="C+";
                            $background="";
                        }
                        elseif($nilai<=68.5)
                        {
                            $mutu=2.75;
                            $huruf="B-";
                            $background="";
                        
                        }
                        elseif($nilai<=72.5)
                        {
                            $mutu=3;
                            $huruf="B";
                            $background="";
                        
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
                            $background="";
                        
                        }
                        else
                        {
                            $mutu=4;
                            $huruf="A";
                            $background="";
                        
                        }
                        $konten .= "
                        <td>$nilai</td>
                        <td>$mutu</td>
                        <td style=$background>$huruf</td>
                        ";
                    }
                }
                $konten .="</tr>";
                echo $konten;
            }
            ?>
        </tbody>
    </table>

</body>
</html>
