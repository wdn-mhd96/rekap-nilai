<?php
require '../connection.php';
if(!isset($_GET['idk']) && !isset($_GET['pid']))
{
    echo "Tidak Ada Menu Dipilih";
    return;
}
$idk = $_GET['idk'];
$taid = $_GET['taid'];
$mhsQ = mysqli_query($connect, "SELECT tmahasiswa.*, tkelas.NamaKelas from tmahasiswa left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas where tmahasiswa.IdKelas = '$idk'");   
$mhn = mysqli_fetch_array($mhsQ);
$n_kelas =  $mhn['NamaKelas'];
$jns = $_GET['jn'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=rekap nilai D & E $n_kelas.xls");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Rekap Nilai D & E <?= $n_kelas ?></h3>
<table class="table table-sm table-bordered" border="1">
<thead>
    <th>No.</th>
    <th>NIM</th>
    <th>Nama</th>
    <th>Nama Mata Kuliah</th>
    <!-- <th>Total Test</th> -->
    <th>Nilai Uts</th>
    <th>NIlai Uas</th>
    <th>Nilai Uprak</th>
    <th>Rata-Rata</th>
    <th>Mutu</th>
    <th>Huruf</th>
    <!-- <th>Aksi</th> -->
</thead>
<tbody>
    
    <?php
    if(!$mhsQ)
    {
        echo "<tr>
                <td>Tidak Ada Data</td>
        </tr>";
    }
    else
    {
    $no = 1;
    mysqli_data_seek($mhsQ,0);
    while($mhs = mysqli_fetch_array($mhsQ)) {
        $nim = $mhs['NIM'];
        $nama = $mhs['NamaMahasiswa'];
        $id = $mhs['IdMahasiswa'];
        $kelas = $mhs['IdKelas'];
        $testQ = mysqli_query($connect, "SELECT ttest.*, tmakul.NamaMakul 
        from ttest 
        left join tmakul on tmakul.IdMakul = ttest.makul
        where ttest.id_kelas = '$kelas' and ttest.id_ta = '$taid'");
        while($test=mysqli_fetch_array($testQ))
        {
            $makul = $test['makul'];
            $namamakul = $test['NamaMakul'];
        $transuas = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '2' and id_ta = '$taid' and nilai > 0 and id_makul = '$makul'");
        $transuts = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '1' and id_ta = '$taid' and nilai > 0 and id_makul = '$makul'");
        $uprak = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '3' and id_ta = '$taid' and id_makul = '$makul'");
            if(mysqli_num_rows($transuas) > 0 || mysqli_num_rows($transuts) > 0)
            {
                $duas = mysqli_fetch_array($transuas);
                $duts = mysqli_fetch_array($transuts);
                $upr = mysqli_fetch_array($uprak);
                $nilaiuts = $duts['nilai'];
                $nilaiuas = $duas['nilai'];
                $nilaiuprak = $upr['nilai'];
                $total = (!mysqli_num_rows($uprak)>0)? ($nilaiuts+$nilaiuas)/2 : ((($nilaiuts+$nilaiuas)/2)+$nilaiuprak)/2;
                if($jns==1)
                {
                    if($nilaiuts < 56)
                    {
                        if($nilaiuts<=45.5)
                        {
                            $mutu=0;
                            $huruf="E";
                            $background="background:red";
                        }
                        else if($nilaiuts<=55.5)
                        {
                            $mutu=1;
                            $huruf="D";
                            $background="background:orange";
                        }
                        elseif($nilaiuts<=61.5)
                        {
                            $mutu=2;
                            $huruf="C";
                            $background="background:yellow";
                        }
                        elseif($nilaiuts<=64.5)
                        {
                            $mutu=2.5;
                            $huruf="C+";
                            $background="";
                        }
                        elseif($nilaiuts<=68.5)
                        {
                            $mutu=2.75;
                            $huruf="B-";
                            $background="";
                        
                        }
                        elseif($nilaiuts<=72.5)
                        {
                            $mutu=3;
                            $huruf="B";
                            $background="";
                        
                        }
                        elseif($nilaiuts<=75.5)
                        {
                            $mutu=3.5;
                            $huruf="B+";
                        }
                        elseif($nilaiuts<=78.5)
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
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $nim ?></td>
            <td><?= $nama ?></td>
            <td><?= $namamakul ?></td>
            <td><?= $nilaiuts ?></td>
            <td><?= $nilaiuas ?></td>
            <td><?= $nilaiuprak ?></td>
            <td><?= $total ?></td>
            <td><?= $mutu ?></td>
            <td style="<?= $background ?>"><?= $huruf ?></td>
            <!-- <td><?= $namamakul?></td> -->
            <!-- <td><a href="action.php?valid=v&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-info">Validasi</a> -->
            <!-- <a href="action.php?valid=h&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-danger">Hapus Mahasiswa</a></td> -->
        </tr>
        <?php
                    }
                }
                else
                {
                if(round($total) < 56)
                {
                    if($total<=45.5)
                        {
                            $mutu=0;
                            $huruf="E";
                            $background="background:red";
                        }
                        else if($total<=55.5)
                        {
                            $mutu=1;
                            $huruf="D";
                            $background="background:orange";
                        }
                        elseif($total<=61.5)
                        {
                            $mutu=2;
                            $huruf="C";
                            $background="background:yellow";
                        }
                        elseif($total<=64.5)
                        {
                            $mutu=2.5;
                            $huruf="C+";
                            $background="";
                        }
                        elseif($total<=68.5)
                        {
                            $mutu=2.75;
                            $huruf="B-";
                            $background="";
                        
                        }
                        elseif($total<=72.5)
                        {
                            $mutu=3;
                            $huruf="B";
                            $background="";
                        
                        }
                        elseif($total<=75.5)
                        {
                            $mutu=3.5;
                            $huruf="B+";
                        }
                        elseif($total<=78.5)
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
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $nim ?></td>
            <td><?= $nama ?></td>
            <td><?= $namamakul ?></td>
            <td><?= $nilaiuts ?></td>
            <td><?= $nilaiuas ?></td>
            <td><?= $nilaiuprak ?></td>
            <td><?= $total ?></td>
            <td><?= $mutu ?></td>
            <td style="<?= $background ?>"><?= $huruf ?></td>
            <!-- <td><?= $namamakul?></td> -->
            <!-- <td><a href="action.php?valid=v&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-info">Validasi</a> -->
            <!-- <a href="action.php?valid=h&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-danger">Hapus Mahasiswa</a></td> -->
        </tr>
        <?php
                }
                }
            }
        }

    }
        
    }
    ?>
</tbody>
</table>   