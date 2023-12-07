<?php
require 'connection.php';
require_once 'function.php';

if (isset($_POST['pilih'])) {
    $scriptId = 'AKfycbzDSIAjtnU8nUngQK0Nd5DSEJ47woJk2ccJpz2Yh2MET74j_HDcQ4zHut1P5aLNM7UF7A';

    $sheets = explode('/' , $_POST['makul']);
    $sheetsId = $sheets[5];
    $judul = filter_var($_POST['judul'], FILTER_SANITIZE_STRING);
    $endPointUrl = "https://script.google.com/macros/s/".$scriptId."/exec?id=".$sheetsId;
    try {
        $response = @file_get_contents($endPointUrl);

        if ($response === false) {
            throw new Exception('Link tidak sesuai');
        }

        $data = json_decode($response, true);
        if ($data === null) {
            throw new Exception('Tidak Ada Data');
        }
    } catch (Exception $e) {
        $exc =  "<div class='alert alert-danger'>" .$e->getMessage()."</div>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Aplikasi Cetak Hasil Ujian</title>
</head>
<body  style="background:radial-gradient(#c1dcf5, #98c8f5); background-repeat: no-repeat;">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height:100vh">
    <?php if(!isset($data))
    {
        echo $exc;
        echo "<a href='index.php' class='btn btn-secondary'>Kembali</a>";
    }
    else {
    ?>
        <h2><?php echo $judul ?></h2>
        <div class="w-75 d-flex justify-content-center">
            <a href="pdf.php?id=<?php echo $sheetsId ?>&judul=<?php echo $judul ?>" class="btn btn-success mt-3 mr-3" target="__blank"> Cetak PDF</a>
            <a href='index.php' class='btn btn-secondary mt-3'>Kembali</a>
        </div>
        <table class="table table-bordered" id="tabel-nilai">
        <thead>
            <tr class="bg-secondary">
                <th>No .</th>
                <th>Nim</th>
                <th>Nama Mahasiswa</th>
                <th>Prodi</th>
                <th>Tingkat</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
                <?php $i= 1; foreach($data as $dataa) {
                ?>
                <tr <?php echo ($dataa['Score'] >56) ? "style='background:rgb(255, 255, 255)'" : "style='background:rgb(255, 100, 100)'" ;?>>
                    <td><?= $i++ ?></td>
                    <td><?= $dataa['NIM']?></td>
                    <td><?= $dataa['Nama Lengkap']?></td>
                    <td><?= $dataa['Prodi']?></td>
                    <td><?= $dataa['Tingkat']?></td>
                    <td><?= $dataa['Score']?></td>
                    <td><?php echo($dataa['Score'] < 56) ?"Tidak Lulus" :"Lulus" ?></td>
                </tr>    
                <?php } ?>
        </tbody>
    </table>
    <?php
        foreach ($data as $ent) {
            $b = (float)$ent['Score'];
            $sum += $b;
        }
        $score = (array_column($data,'Score')) ? array_column($data,'Score') : array(0) ; 
        $count = count($score);
        $avg = $sum/$count;
        
        $avgg =  number_format((float)$avg,0,'.','');
        $max =  max($score);
        $min = min($score);
        $lulus = 0;
        $tidakLulus = 0;
        foreach ($data as $item) {
            ($item['Score'] > 55) ? $lulus++ : $tidakLulus++ ;
        }   
    ?>
    <table class="table w-25 table-border">
        <tr>
            <td>Rata-Rata :</td>
            <td><?php echo $avgg ?></td>
        </tr>
        <tr>
            <td>Nilai Tertinggi</td>
            <td><?php echo $max;?></td>
        </tr>
        <tr>
            <td>Nilai Terendah</td>
            <td><?php echo $min ?></td>
        </tr>
        <tr>
            <td>LULUS</td>
            <td><?php echo $lulus ?></td>
        </tr>
        <tr>
            <td>TIDAK LULUS</td>
            <td><td><?php echo $tidaklulus ?></td></td>
        </tr>
    </table>
    <?php } ?>

    </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
        $(document).ready(function(){
        $('#tabel-nilai').DataTable();
    });
    </script>
</body>
</html>