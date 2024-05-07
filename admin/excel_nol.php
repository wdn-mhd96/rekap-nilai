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

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=rekap nilai nol $n_kelas.xls");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>Rekap Tidak Ikut Tes <?= $n_kelas ?></h4>
<table class="table table-sm table-bordered" border="1">
<thead>
    <th>No.</th>
    <th>NIM</th>
    <th>Nama</th>
    <!-- <th>Total Test</th> -->
    <th>Tidak Ikut UTS</th>
    <th>Tidak Ikut UAS</th>
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
        $transuas = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '2' and id_ta = '$taid' and nilai = 0 and id_makul = '$makul'");
        $transuts = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '1' and id_ta = '$taid' and nilai = 0 and id_makul = '$makul'");
            if(mysqli_num_rows($transuas) > 0 || mysqli_num_rows($transuts) > 0)
            {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $nim ?></td>
            <td><?= $nama ?></td>
            <!-- <td><?= $namamakul?></td> -->
            <td><?= (mysqli_num_rows($transuts) > 0) ? $namamakul : "IKUT"?></td>
            <td><?= (mysqli_num_rows($transuas) > 0) ? $namamakul : "IKUT"?></td>
            <!-- <td><a href="action.php?valid=v&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-info">Validasi</a> -->
            <!-- <a href="action.php?valid=h&idm=<?= $nim ?>&idk=<?= $kelas ?>&pid=<?= $sid ?>" class="btn btn-sm btn-danger">Hapus Mahasiswa</a></td> -->
        </tr>
        <?php
            }
            }

    }
        
    }
    ?>
</tbody>
</table>   