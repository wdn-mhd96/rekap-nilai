<?php
require '../connection.php';
require '../function.php';
session_start();
$prdQ = mysqli_query($connect,"SELECT tperiode.*, ttahun.nama_ta FROM tperiode left join ttahun on ttahun.id_ta = tperiode.tahun where tperiode.terpilih = '1'");
$prd=mysqli_fetch_assoc($prdQ);
$periode = $prd['nama_ta']." - ";
$periode .= ($prd['jenis_tes']==1)? "UTS" : "UAS";
$sid = $prd['id_periode'];
$ta_id = $prd['tahun'];
$jenis = $prd['jenis_tes'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/style.css" rel="stylesheet">
</head>
<body>

    
    
    <div id="wrapper" class="toggled">
        <div class="nav-bar w-100 d-flex justify-content-between">
            <div class="wrap">
                <a href="#menu-toggle" class="text-light mr-3" id="menu-toggle"><i class="fa-solid fa-lg fa-3x fa-bars"></i></a>
                <span class="text-light">Admin</span>
            </div>
            <div class="periode d-flex justify-content-between">
                <div class="dropdown">
                    <a href="#" class="text-light ml-3 dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $periode ?></a>
                    <div class="dropdown-menu ml-3" aria-labelledby="dropdownMenuLink">
                        <ul class="list-group">
                            <li class="list-group-item"><a class="dropdown-item" href="?pg=periode&act=ganti"><i class="fa-solid fa-refresh mr-2"></i>Ganti</a></li>
                            <li class="list-group-item"><a class="dropdown-item" href="?pg=periode&act=tambah"><i class="fa-solid fa-calendar-plus mr-2"></i>Tambah</a></li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="text-light ml-3" role="button" id="aaa" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-xl fa-circle-user"></i></a>
                    <div class="dropdown-menu dropdown-menu-right ml-3" aria-labelledby="aaa">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            
            <ul class="sidebar-nav">
                <li class="sidebar-brand mt-3">
                    <a href="">
                       <h4>Wijaya Husada</h4>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" class="menu-link">Dashboard</a>
                </li>
                <li>
                    <a href="?pg=makul" class="menu-link">Test</a>
                </li>
               
                <li>
                <a class="menu-drop dropdown-toggle menu-link" href="#menu-transkrip" data-toggle="collapse" aria-expanded="false">
                        Transkrip
                    </a>
                    <ul class="collapse p-0 bg-dark" id="menu-transkrip" type="none" style="border-right:'solid 3px red'">
                        <li class="nav-item"><a class="menu-link sub-menu" href="?pg=transkrip&act=nilai">Rekap Nilai</a></li>
                        <li class="nav-item"><a class="menu-link sub-menu" href="?pg=transkrip&act=de">Rekap D & E</a></li>
                        <li class="nav-item"><a class="menu-link sub-menu" href="?pg=transkrip&act=nol">Rekap Tidak Ikut Tes</a></li>
                        <!-- <li class="nav-item"><a class="menu-link sub-menu" href="?pg=transkrip&act=nmakul">Rekap Per Matakuliah</a></li> -->
                    </ul>
                </li>
                <li>
                    <a class="menu-dropp dropdown-toggle menu-link" href="#menu-manajemen" data-toggle="collapse" aria-expanded="false">
                        Manajemen
                    </a>
                    <ul class="collapse p-0 bg-dark" id="menu-manajemen" type="none" style="border-right:'solid 3px red'">
                        <!-- <li class="nav-item "><a class="menu-link sub-menu" href="?pg=periode">Periode</a></li> -->
                        <li class="nav-item"><a class="menu-link sub-menuu" href="?pg=mahasiswa">Mahasiswa</a></li>
                        <li class="nav-item"><a class="menu-link sub-menuu" href="?pg=mmakul">Mata Kuliah</a></li>
                        <!-- <li class="nav-item"><a class="menu-link sub-menuu" href="?pg=dosen">Dosen</a></li> -->
                    </ul>
                </li>
                <li>
                    <a href="?pg=uprak" class="menu-link">Ujian Praktek</a>
                </li>
                <li>
                    <a href="?pg=rev" class="menu-link">Nilai Per Mahasiswa</a>
                </li>

            </ul>

            <ul>
                <li>Uhuy</li>
            </ul>
            
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="min-height:100vh">
            <div class="container-fluid">
            <?php
            if(!isset($_GET['pg']))
            {
               ?> <h2>Ini Adalah Aplikasi Untuk Pencetakan Hasil Nilai</h2> 
                    <div class="card bg-info  p-2 mt-2">
                        <div class="card-header border">
                            <h4 class="text-light">Dashboard Menu</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-light">
                               <b> Bagi dosen yang ingin melakukan pencetakan hasil nilai UTS / UAS Silahkan gunakan aplikasi ini.
                            </p>
                        </div>
                    </div>
               <?php
            }
            else {
            switch ($_GET['pg']) {
                // Manajemen Nilai Tes
                case "nilai" :
                    if(!$_GET['act'])
                    {
                        $info = 'tidak ada file dipilih';
                        $kelass='';
                        if(isset($_GET['idt']))
                        {   
                            $jn = (isset($_GET['uprak'])) ? 3 : $jenis;
                            $kelass =$_GET['idk']; 
                            $idmakul = $_GET['idm'];
                            $uprak = '';
                            if($jn==3)
                            {
                              $sqlmakul = "SELECT ttest.id_test, ttest.uprak, ttest.makul,
                            tkelas.NamaKelas,tmakul.NamaMakul, ttest.id_kelas
                            from ttest
                            left join tkelas on tkelas.IdKelas = ttest.id_kelas
                            left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas='$kelass' and ttest.makul = '$idmakul' and ttest.uprak=0";
                            $uprak = "<a href='../assets/format_uprak.csv' class='btn btn-sm btn-success'>Download Format Uprak</a>";
                            }
                            elseif($jn==2)
                            {
                              $sqlmakul = "SELECT ttest.id_test, ttest.status, ttest.makul,
                            tkelas.NamaKelas,tmakul.NamaMakul, ttest.id_kelas
                            from ttest
                            left join tkelas on tkelas.IdKelas = ttest.id_kelas
                            left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas='$kelass' and ttest.makul = '$idmakul' and ttest.status=0";
                            }
                            elseif($jn==1)
                            { $sqlmakul = "SELECT ttest.id_test, ttest.status, ttest.makul,
                            tkelas.NamaKelas,tmakul.NamaMakul, ttest.id_kelas
                            from ttest
                            left join tkelas on tkelas.IdKelas = ttest.id_kelas
                            left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas='$kelass' and ttest.makul = '$idmakul' and ttest.status_uts=0";
                            }
                            $querymakul = mysqli_query($connect, $sqlmakul);
                            $makul = mysqli_fetch_array($querymakul);
                        }
                        if(isset($_POST['import_csv'])) 
                        {
                            unset($_SESSION['nilai']);
                           unset($_SESSION['idTest']);
                           unset($_SESSION['idKelas']);
                           unset($_SESSION['idmakul']);
                           unset($_SESSION['jn']);
                            $dataNilai = array();
                            $jns = $_POST['jenis'];
                            $idKelas = $_POST['id_kelas'];
                            $idTest = $_POST['id_test'];
                            $idmakul = $_POST['id_makul'];
                            $mhs = array();
                            $mhsQ = mysqli_query($connect,"SELECT tmahasiswa.*,tkelas.NamaKelas from tmahasiswa left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas where tmahasiswa.IdKelas = '$idKelas'");
                            while($mhsa = mysqli_fetch_array($mhsQ)){
                                $mhs[] = $mhsa;
                            }
                            $filetype = array(
                                'text/x-comma-separated-values',
                                'text/comma-separated-values',
                                'application/octet-stream',
                                'application/vnd.ms-excel',
                                'application/x-csv',
                                'text/x-csv',
                                'text/csv',
                                'application/csv',
                                'application/excel',
                                'application/vnd.msexcel',
                                'text/plain',
                                'csv'
                            );
                            if(!empty($_FILES['imp_csv']['name']) && in_array($_FILES['imp_csv']['type'], $filetype)) 
                            {   
                                
                                $csvfile = fopen($_FILES['imp_csv']['tmp_name'], 'r');
                                $header = fgetcsv($csvfile, 10000, ',');
                                $nimi = array_search('nim', array_map('strtolower', $header));
                                $nilaii = array_search('total score', array_map('strtolower', $header));
                                if($nimii !== false && $nilaii !== false)
                                {

                                while (($getData = fgetcsv($csvfile, 10000, ",")) !== FALSE) {
                                    $nim = $getData[$nimi];
                                    $nilai = $getData[$nilaii];
                                    if($nim !== null && $nilai !== null) {
                                        $data = array('nim' => $nim, 'score' => $nilai);
                                        $dataNilai[] = $data;
                                    }
                                } 
                                fclose($csvfile);
                                $_SESSION['nilai'] = $dataNilai;
                                $_SESSION['idTest'] = $idTest;
                                $_SESSION['idKelas'] = $idKelas;
                                $_SESSION['idmakul'] = $idmakul;
                                $_SESSION['jn'] = $jns;
                                
                                }
                                else
                                {
                                    $info =  "Kolom NIM/ total skor tidak ditemukan, pastikan csv memiliki kolom nim dan total skor agar data dapat di upload";
                                }
                            }
                            else {
                                $info =  "format tidak sesuai";
                            }
                           

                        }
                        if(isset($_POST['exp'])) {
                            $expNilai = $_SESSION['nilai'];
                            $expId = $_SESSION['idTest'];
                            $expkelas = $_SESSION['idKelas'];
                            $expmakul = $_SESSION['idmakul'];
                            $exjn = $_SESSION['jn'];
                            if($exjn==2)
                            {
                            mysqli_query($connect,"UPDATE ttest set status = 1 where id_test = '$expId'");
                            }
                            elseif($exjn==1)
                            {
                                mysqli_query($connect,"UPDATE ttest set status_uts = 1 where id_test = '$expId'");
                            }
                            elseif($exjn==3)
                            {
                                mysqli_query($connect,"UPDATE ttest set uprak = 1 where id_test = '$expId'");
                            }
                            $mhsQ = mysqli_query($connect,"SELECT tmahasiswa.*,tkelas.NamaKelas from tmahasiswa left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas where tmahasiswa.IdKelas = '$expkelas'");
                            while($mhsa = mysqli_fetch_array($mhsQ)){
                            
                            $nim =   $mhsa['NIM'];
                            $score = (in_array($nim, array_column($expNilai, 'nim'))) ? $expNilai[array_search($nim, array_column($expNilai, 'nim'))]['score'] : 0;
                            $query = mysqli_query($connect,"INSERT into ttranskrip_nilai values ('','$expId','$expkelas','$exjn','$ta_id','$expmakul','$nim','$score')");
                           echo ($query) ? "<script>alert('Berhasil Export Data'); window.location = 'dashboard.php?pg=makul&idk=$expkelas';</script>" 
                                            : "<script>alert('Gagal Export Data'); window.location = 'dashboard.php?pg=makul&idk=$expkelas';</script>";
                        // var_dump($nim);
                        // var_dump($score);
                           }
                           unset($_SESSION['nilai']);
                           unset($_SESSION['idTest']);
                           unset($_SESSION['idKelas']);
                           unset($_SESSION['idmakul']);
                        }
                                    
                    
                    ?>
                  
                            <h4>Import NIlai Hasil Test</h4>
                            <div class="card m-auto" style="width:23rem;">
                                <div class="card-body">
                                    <?= $uprak ?>
                                    <div class="form-group">
                                    <form action='' method='post' enctype='multipart/form-data'>
                                        <input type="hidden" name="id_test" value="<?php echo $makul['id_test'] ?>">
                                        <input type="hidden" name="jenis" value="<?php echo $jn?>">
                                    <div class='form-group'>
                                        <label for=''>Jurusan - Tingkat</label>
                                        <input type="text" name='id_makul' value ="<?php echo $makul['NamaKelas'] ?>" class="form-control form-control-sm" readonly>
                                        <input type='hidden' name = 'id_kelas' value="<?php echo $makul['id_kelas'] ?>">    
                                    </div>
                                    <div class='form-group'>
                                        <label for=''>Mata Kuliah</label>
                                        <input type="text" name='kelas' value ="<?php echo $makul['NamaMakul'] ?>" class="form-control form-control-sm" readonly>
                                        <input type='hidden' name='id_makul' value="<?php echo $makul['makul'] ?>">    
                                    </div>
                                    <div class='form-group'>
                                        <label for=''>Import File CSV</label>
                                        <input type='file' name='imp_csv' accept=".csv" class='form-control form-control-sm' required>
                                    </div>
                                </div>
                                <div class='card-footer text-center'>
                                    <input type='submit' name='import_csv' value='import' class='btn btn-sm btn-primary '>
                                    <a href="javascript:history.go(-1)" class="btn btn-sm btn-secondary">Kembali</a>
                                </div>
                            </form>      
                                        
                                               
                                        </div>
                                    </div>
                            </div>

                            <?php if(!isset($dataNilai)) {?>
                                <p class="text-center mt-3"><?php echo $info ?></p>
                                <?php } else { ?>
                                    <table class="table table-bordered table-stripped table-sm" id="tabel-nilai">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th>No.</th>
                                                <th>Nim</th>
                                                <th>Nilai</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Ket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1;
                                                $err = 0;
                                                $nimCounts = array_count_values(array_column($dataNilai, 'nim'));
                                                foreach($dataNilai as $nilai)
                                                {
                                                    $key = array_search($nilai['nim'], array_column($mhs, 'NIM'));
                                                    $score = explode(" / ",$nilai['score'])
                                                ?>
                                                
                                                    <tr style="background:<?php echo  (!in_array($nilai['nim'], array_column($mhs, 'NIM')) || $nimCounts[$nilai['nim']] > 1)? 'red' : 'white';
                                                        
                                                    ?>">
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $nilai['nim']?></td>
                                                        <td><?php echo $score[0]?></td>
                                                        <td><?php echo ($key !== false) ? $mhs[$key]['NamaMahasiswa'] :""?></td>
                                                        <td><?php echo ($key !== false) ? $mhs[$key]['NamaKelas'] :""?></td>
                                                        <td><?php echo ($key !== false) ? "" :"NIM tidak ditemukan";
                                                            echo ($nimCounts[$nilai['nim']] > 1) ? "terdapat NIM yang sama" : "";
                                                            ?></td>
                                                    </tr>
                                                <?php
                                                    (!in_array($nilai['nim'], array_column($mhs, 'NIM')) || $key === false)? $err++ : null;
                                                }
                                                
                                            ?>    
                                        </tbody>
                                    </table>
                                    <form action="" method="post" id="exportForm" class="text-center">
                                        <input type="hidden" name="err" id="err" value="<?php echo $err ?>">
                                        <input type="submit" class="btn btn-info" name="exp" id="export" value="export">
                                    </form>
                                    <?php } ?>
   
                    <?php
                }
                break;

                // Manajemen Tes 
                case "makul":
                    if(!isset($_GET['act']))
                    {
                        if(isset($_POST['kelas']) || isset($_GET['idk']))
                        {
                            $kelass =(isset($_GET['idk'])) ?$_GET['idk'] :$_POST['kelas'];
                        $sql = ($jenis==2)  
                        ?"SELECT ttest.id_test, ttest.status, ttest.makul, ttest.id_kelas,
                        tkelas.NamaKelas,  tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas = '$kelass' order by ttest.status ASC"
                        : "SELECT ttest.id_test, ttest.status_uts, ttest.makul, ttest.id_kelas,
                        tkelas.NamaKelas,  tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas = '$kelass' order by ttest.status_uts ASC";
                        }
                        else
                        {
                        $sql = ($jenis==2) 
                        ?"SELECT ttest.id_test, ttest.status, ttest.makul, ttest.id_kelas,
                        tkelas.NamaKelas, tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' order by ttest.status ASC"
                        :  "SELECT ttest.id_test, ttest.status_uts, ttest.makul, ttest.id_kelas,
                        tkelas.NamaKelas, tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' order by ttest.status_uts ASC";  
                        }
                        $query = mysqli_query($connect, $sql);

                        ?>
                        <div class="container d-flex flex-column align-items-center">
                            <div class="tambah w-100 mb-3 d-flex justify-content-between"><h4>List Mata Kuliah Test</h4>
                                <span>
                                    <a href="?pg=makul&act=tambah" class="btn btn-sm btn-success">Tambah Test</a>
                                    <a href="?pg=makul" class="btn btn-sm btn-info">Tampilkan Semua Data</a>
                                </span>
                            </div>
                            <form action="" method="post">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="makuls" class='form-control form-control-sm mb-3' onchange='this.form.submit()'>
                                    <option value="">--</option>
                                    <?php
                                    $kelasQ = mysqli_query($connect, "SELECT * from tkelas");
                                    while($kelas = mysqli_fetch_array($kelasQ))
                                    {
                                        echo "<option value='$kelas[IdKelas]'>$kelas[NamaKelas]</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                            <table class="table table-bordered w-100" id=<?php echo (mysqli_num_rows($query)>0) ?"tabel-nilai" : "";?>>
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <!-- <th>Dosen</th> -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    if(mysqli_num_rows($query)>0)
                                    {
                                        $i=1;
                                        while($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr style="background:<?php echo ($jenis == 2) ? (($row['status'] == 1) ? 'aqua' : '') : (($row['status_uts'] == 1) ? 'aqua' : ''); ?>">
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['NamaMakul'] ?></td>
                                            <td><?php echo $row['NamaKelas'] ?></td>
                                            <!-- <td><?php echo $row['Nama'] ?></td> -->
                                            <td><?php 
                                            if($jenis==2)
                                            {
                                            echo ($row['status']==0)? "<a href='?pg=makul&act=edit&id=$row[id_test]' class='btn btn-sm btn-warning'>Edit</a>
                                                <a onclick ='return confirm(`Yakin Hapus Data $row[NamaMakul]`)' href='?pg=makul&act=hapus&id=$row[id_test]' class='btn btn-sm btn-danger'>Hapus</a>
                                                <a href = '?pg=nilai&idt=$row[id_test]&idk=$row[id_kelas]&idm=$row[makul]' class='btn btn-sm btn-info'>Upload Data</a>" 
                                                
                                                : "<a onclick='return confirm(`yakin hapus data $row[NamaMakul] ?`)' href='action.php?delt=$row[id_test]&jenis=$jenis' class='btn btn-sm btn-secondary'>Hapus Data Tes</a>
                                                <a href='cetak_mkl.php?tid=$row[id_test]&idk=$row[id_kelas]&jenis=$jenis' class='btn btn-sm btn-light' target='__blank'>Cetak Data</a>
                                                ";
                                            }
                                            elseif($jenis==1)
                                            {
                                                echo ($row['status_uts']==0)? "<a href='?pg=makul&act=edit&id=$row[id_test]' class='btn btn-sm btn-warning'>Edit</a>
                                                <a onclick ='return confirm(`Yakin Hapus Data $row[NamaMakul]`)' href='?pg=makul&act=hapus&id=$row[id_test]' class='btn btn-sm btn-danger'>Hapus</a>
                                                <a href = '?pg=nilai&idt=$row[id_test]&idk=$row[id_kelas]&idm=$row[makul]' class='btn btn-sm btn-info'>Upload Data</a>" 
                                                
                                                : "<a onclick='return confirm(`yakin hapus data $row[NamaMakul] ?`)' href='action.php?delt=$row[id_test]&jenis=$jenis' class='btn btn-sm btn-secondary'>Hapus Data Tes</a>
                                                <a href='cetak_mkl.php?tid=$row[id_test]&idk=$row[id_kelas]&jenis=$jenis' class='btn btn-sm btn-light' target='__blank'>Cetak Data</a>
                                                ";
                                            } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    }
                                    else { 
                                        
                                    ?>
                                        <tr>
                                            <td>Data Tidak Ditemukan</td>
                                        </tr>
                                    <?php  }?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    else
                    {
                        if($_GET['act']=="tambah")
                        {
                           ?>
                           <div class="container d-flex justify-content-center">
                            <div class="card" style="width:30rem">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>Tambah Test</h4>
                                    <a href="?pg=makul" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="card-body">
                                    <form action="action.php" method="post" id="form-tambah">
                                        <input type="hidden" name='periode' value="<?php echo $sid ?>">
                                        <input type="hidden" name='ta' value="<?php echo $ta_id ?>">
                                        <div class="form-group">
                                            <label for="">Jurusan</label>
                                            <select name="jurusan" id="" class="form-control" required>
                                                <?php
                                                    $sql = mysqli_query($connect,"SELECT * from tkelas");
                                                    while($data = mysqli_fetch_array($sql))
                                                    {
                                                        echo "<option value='$data[IdKelas]'>$data[NamaKelas]</option>";
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Mata Kuliah</label>
                                            <input type="text" id="makul" name='makul' class="form-control" onkeyup="showSuggestionMakul(this.value)" autocomplete="off" required>
                                            <input type="hidden" id="kdMakul" name="KdMakul">
                                            <div id="suggestion-makul"></div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="">Dosen</label>
                                            <input type="text" id="search" name='dosen' class="form-control" onkeyup="showSuggestion(this.value)" autocomplete="off" required>
                                            <input type="hidden" id="kdDosen" name="KdDosen">
                                            <ul id="suggestion-box"></ul>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label for="">Link google sheets</label>
                                            <input type="text" name="sheets" class="form-control" id="sheets" required>
                                            <div id="check-data"></div>
                                            <button class="btn btn-sm btn-warning mt-2" id="cek" name="cek">Cek Link</button>
                                        </div> -->
                                </div>
                                <div class="card-footer">
                                        <input type="submit" name="tambah_test" class="btn btn-info" value="Simpan" id="submit">
                                    </form>
                                </div>
                            </div>
                        
                        </div>
                           <?php
                        }
                        elseif($_GET['act']=="edit")
                        {
                            $id = $_GET['id'];
                            $sql = "SELECT ttest.*,tmakul.NamaMakul from ttest 
                            left join tmakul on tmakul.IdMakul = ttest.makul 
                            where ttest.id_test = '$id'";
                            $query = mysqli_query($connect, $sql);
                            $row = mysqli_fetch_array($query);
                           ?>
                           <div class="container d-flex justify-content-center">
                            <div class="card" style="width:30rem">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>Edit Test</h4>
                                    <a href="?pg=makul" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="card-body">
                                    <form action="action.php" method="post" id="form-tambah">
                                        <input type="hidden" name="id_test" value="<?php echo $row['id_test'] ?>">
                                        <input type="hidden" name='periode' value="<?php echo $sid ?>">
                                        <input type="hidden" name='ta' value="<?php echo $ta_id ?>">
                                        <div class="form-group">
                                            <label for="">Jurusan</label>
                                            <select name="jurusan" id="" class="form-control" required>
                                                <?php
                                                    $sql = mysqli_query($connect,"SELECT * from tkelas");
                                                    while($data = mysqli_fetch_array($sql))
                                                    {
                                                        ($row['id_kelas']==$data['IdKelas']) ? $selected = 'selected' : $selected = '' ;
                                                        echo "<option value='$data[IdKelas]' $selected>$data[NamaKelas]</option>";
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Mata Kuliah</label>
                                            <input type="text" id="makul" name='makul' class="form-control" onkeyup="showSuggestionMakul(this.value)"  value="<?php echo $row['NamaMakul']?>" autocomplete="off" required>
                                            <input type="hidden" id="kdMakul" name="KdMakul" value="<?php echo $row['makul']?>">
                                            <div id="suggestion-makul"></div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="">Dosen</label>
                                            <input type="text" id="search" name='dosen' class="form-control" onkeyup="showSuggestion(this.value)"  value="<?php echo $row['Nama']?>"required>
                                            <input type="hidden" id="kdDosen" name="KdDosen" value="<?php echo $row['dosen']?>">
                                            <ul id="suggestion-box"></ul>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label for="">Link google sheets</label>
                                            <input type="text" name="sheets" class="form-control" id="sheets" value="<?php echo $row['sheets_id']?>" required>
                                            <div id="check-data"></div>
                                            <button class="btn btn-sm btn-warning mt-2" id="cek" name="cek">Cek Link</button>
                                        </div> -->
                                </div>
                                <div class="card-footer">
                                        <input type="submit" name="update_test" class="btn btn-info submit" value="Update" id="submit">
                                    </form>
                                </div>
                            </div>
                        
                        </div>
                           <?php
                        }
                        else if($_GET['act']=="hapus")
                    {
                    $id=$_GET['id'];
                    $sql="DELETE from ttest where id_test='$id'";
                    $query=mysqli_query($connect,$sql);
                    echo ($query) ? "<script>alert('Berhasil Hapus Data'); window.history.go(-1);</script>" 
                                  : "<script>alert('Gagal Hapus Data'); window.history.go(-1);</script>";
                    }
                    
                    }
                break;

                // Manajemen Periode
                case "periode":
                    if(!isset($_GET['act']))
                    {
                        echo "Tidak ada menu dipilih";
                    }
                    elseif($_GET['act']=='tambah') 
                    {
                        ?>
                        <div class="card m-auto" style="width:25rem">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Tambah Periode</h3>
                                <a onClick="window.history.go(-1); return false" href="#"class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                            <div class="card-body">
                                <form action="action.php" method="post">
                                    <div class="form-group">
                                        <label for="">Tahun Akademik</label>
                                        <select class="form-control form-control-sm" name="tahun" id="">
                                            <?php
                                                $taQ = mysqli_query($connect, "SELECT * from ttahun");
                                                while($taf = mysqli_fetch_array($taQ))
                                                {
                                                    echo "<option value='$taf[id_ta]'>$taf[nama_ta]</option>";
                                                }
                                            ?>
                                        </select>
                                        <a href="?pg=periode&act=tambahtahun" class="btn btn-sm btn-info w-100 mt-3">Tambah Tahun Akademik</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jenis Tes</label>
                                        <select class="form-control form-control-sm" name="jenis" id="">
                                            <option value="1">UTS</option>
                                            <option value="2">UAS</option>
                                        </select>
                                    </div>
                                    <div class="form-inline">
                                        <input type="checkbox" name='pilih' id='pilih' class="form-control mr-2">
                                        <label for="#pilih">Jadikan periode terpilih</label>
                                    </div>
                            </div>
                            <div class="card-footer text-center">
                                        <input type="submit" value="Tambah" class="btn btn-sm btn-primary" name="tambah_periode">
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    elseif($_GET['act']=="ganti")
                    {
                        $periodeQ = mysqli_query($connect,"SELECT tperiode.*, ttahun.nama_ta from tperiode left join ttahun on ttahun.id_ta = tperiode.tahun order by tahun asc");
                        ?>
                            <div class="container w-50 d-flex justify-content-center align-items-center flex-column">
                                <h3>Ganti Periode  Terpilih</h3>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <th style="width:20px">No.</th>
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    <!-- <a onclick='return confirm(`hapus data $dataP[tahun] - $jenis?`);'href='action.php?prd=del&pid=$dataP[id_periode]&sid=$sid' class='btn btn-sm btn-danger'>Delete</a> -->
                                        <?php
                                        $no = 1;
                                        while($dataP = mysqli_fetch_array($periodeQ))
                                        {
                                            $noo = $no++;
                                            $sel = ($dataP['terpilih']==1) ? "style='background:lightgray;'" : "";
                                            $check = ($dataP['terpilih']==1) ? "&#10003;" : "";
                                            $id = ($dataP['terpilih']==1) ? "&#10003;" : "";
                                            $jenis = ($dataP['jenis_tes']==1)? "UTS" : "UAS";
                                            echo "
                                            <tr $sel>
                                                <td>$noo</td>
                                                <td>$dataP[nama_ta] - $jenis</td>
                                                <td>
                                                    <a href='action.php?prd=ganti&pid=$dataP[id_periode]&sid=$sid' class='btn btn-sm btn-success'>Ganti</a>
                                                    <a href='dashboard.php?pg=periode&act=edit&pid=$dataP[id_periode]' class='btn btn-sm btn-warning'>Edit</a>
                                                    
                                                    $check
                                                </td>
                                            </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                    }
                    elseif($_GET['act']=="edit")
                    {
                        if(!$_GET['pid'])
                        {
                            echo "Tidak Ada Periode Dipilih";
                            return;
                        }
                        $pid = $_GET['pid'];
                        $prq = mysqli_query($connect, "SELECT * from tperiode where id_periode = '$pid'");
                        if(!mysqli_num_rows($prq)>0)
                        {
                            echo "Tidak Ada Periode Dipilih";
                            return;
                        }
                        $prr = mysqli_fetch_array($prq);
                        ?>
                        <div class="card m-auto" style="width:25rem">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Tambah Periode</h3>
                                <a onClick="window.history.go(-1); return false" href="#"class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                            <div class="card-body">
                                <form action="action.php" method="post">
                                    <input type="hidden" name="idp" id="" class="form-control form-control-sm" value="<?= $prr['id_periode'] ?>">
                                    <div class="form-group">
                                        <label for="">Tahun Akademik</label>
                                        <select class="form-control form-control-sm" name="tahun" id="">
                                            <?php
                                                $taQ = mysqli_query($connect, "SELECT * from ttahun");
                                                while($taf = mysqli_fetch_array($taQ))
                                                {
                                                        $selected = ($prr['tahun']==$taf['id_ta']) ? 'selected' : '';
                                                    echo "<option value='$taf[id_ta]' $selected>$taf[nama_ta]</option>";
                                                }
                                            ?>
                                        </select>
                                        <a href="" class="btn btn-sm btn-info w-100 mt-3">Tambah Tahun Akademik</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jenis Tes</label>
                                        <select class="form-control form-control-sm" name="jenis" id="">
                                            <option value="1">UTS</option>
                                            <option value="2">UAS</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-inline">
                                        <input type="checkbox" name='pilih' id='pilih' class="form-control mr-2">
                                        <label for="#pilih">Jadikan periode terpilih</label>
                                    </div> -->
                            </div>
                            <div class="card-footer text-center">
                                        <input type="submit" value="Tambah" class="btn btn-sm btn-primary" name="update_periode">
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    elseif($_GET['act']=='tambahtahun')
                    {
                        ?>
                        <div class="card m-auto" style="width:23rem">
                            <div class="card-header"><h4>Form Tambah Tahun Akademik</h4></div>
                            <form action="action.php" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <select name="tahun" id="" class="form-control form-control-sm">
                                        <?php
                                        for($i=date('Y'); $i >=2000; $i--)
                                        {
                                            $ii = $i+1;
                                            echo "<option value='$i/$ii'>$i/$ii</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis</label>
                                    <select name="gg" id="" class="form-control form-control-sm">
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                    <input type="submit" value="Tambah" name="tambah_tahun" class="btn btn-sm btn-info mr-2">
                                    <a href="?pg=periode&act=tambah" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                            </form>
                        </div>
                        <?php
                    }
                break;

                // manajemen mahasiswa
                case "mahasiswa":
                    if(!isset($_GET['act']))
                    {
                        $kelas = $_POST['kelas'];
                    $sql = (isset($_POST['kelas'])) 
                    ? "SELECT tmahasiswa.*, tkelas.NamaKelas from tmahasiswa
                    left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas
                    where tmahasiswa.IdKelas = '$kelas' order by tmahasiswa.IdKelas ASC"

                    :"SELECT tmahasiswa.*, tkelas.NamaKelas from tmahasiswa
                    left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas
                    order by IdKelas ASC
                    ";
                    $mhsq = mysqli_query($connect, $sql);
                    $msg = '';
                    if(isset($_GET['msg'])){
                        if($_GET['msg']=='suc')
                        {
                            $ttl = $_GET['suc'];
                           $msg =  "<div class='alert alert-success alert-sm'>Berhasil Tambah $ttl Data Mahasiswa</div>";
                        }
                        elseif($_GET['msg']=='fail')
                        {
                            $msg =  "<div class='alert alert-danger alert-sm'>Gagal Tambah Data</div>";

                        }
                        elseif($_GET['msg']=='editms')
                        {
                            $msg =  "<div class='alert alert-success alert-sm'>Berhasil Edit Data Mahasiswa</div>";

                        }
                        elseif($_GET['msg']=='editmg')
                        {
                            $msg =  "<div class='alert alert-danger alert-sm'>Gagal Edit Data Mahasiswa</div>";

                        }
                        elseif($_GET['msg']=='hapusms')
                        {
                            $msg =  "<div class='alert alert-success alert-sm'>Berhasil Hapus Data Mahasiswa</div>";

                        }
                        elseif($_GET['msg']=='hapusmg')
                        {
                            $msg =  "<div class='alert alert-danger alert-sm'>Gagal Hapus Data Mahasiswa</div>";

                        }
                        elseif($_GET['msg']=='mhapuss')
                        {
                            $msg =  "<div class='alert alert-success alert-sm'>berhasil hapus Data massal</div>";

                        }
                        elseif($_GET['msg']=='mhapusg')
                        {
                            $msg =  "<div class='alert alert-danger alert-sm'>Gagal hapus Data massal</div>";

                        }
                    }
                    ?>
                    
                        <h3>List Data Mahasiswa</h3>
                        <?php echo $msg ?>
                        <div class="wrap"> 
                        <a href="?pg=mahasiswa&act=tambah" class="btn btn-sm btn-info">Tambah Manual Mahasiswa</a>
                        <a href="?pg=mahasiswa&act=import" class="btn btn-sm btn-primary">Import Mahasiswa</a>
                        <a href="?pg=mahasiswa&act=migrasi" class="btn btn-sm btn-success">Migrasi Mahasiswa</a>
                        <a href="?pg=mahasiswa&act=mhapus" class="btn btn-sm btn-danger">Hapus Massal Mahasiswa</a>
                        <form action="" method="post">
                            <div class="form-inline">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="makuls" onchange="this.form.submit()" class="form-control ml-3 mt-3 mb-3">
                                    <?php
                                    $kelasQ =mysqli_query($connect,"SELECT * from tkelas");
                                    while($kelas = mysqli_fetch_array($kelasQ)) {
                                        echo "<option value='$kelas[IdKelas]'>$kelas[NamaKelas]</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    </form>
                    <table class="table table-sm table-bordered text-center" id="tabel-nilai">
                        <thead>
                            <tr>
                                <th>No.</td>
                                <td>Nama</td>
                                <td>Kelas</td>
                                <td>Nim</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;
                            while($mhs = mysqli_fetch_array($mhsq)) {?>
                                <tr>
                                    <td><?php echo $no++?></td>
                                    <td><?php echo $mhs['NamaMahasiswa']?></td>
                                    <td><?php echo $mhs['NamaKelas']?></td>
                                    <td><?php echo $mhs['NIM']?></td>
                                    <td>
                                        <a href="?pg=mahasiswa&act=edit&mid=<?php echo $mhs['IdMahasiswa']?>" class='btn btn-sm btn-warning'>Edit</a>
                                        <a onclick="return confirm('Yakin Hapus <?php echo $mhs['NamaMahasiswa'] ?>?')"href="action.php?mhs=hapus&mid=<?php echo $mhs['IdMahasiswa']?>" class='btn btn-sm btn-danger'>Hapus</a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        
                        <?php
                    }
                    elseif($_GET['act']=="import")
                    {
                        ?>
                            <div class="card m-auto" style="width:23rem">
                                <div class="card-header d-flex justify-content-between align-items-center flex-column">
                                    <a href="../format/format upload mahasiswa.csv" class='btn btn-sm btn-success'>Download Format Import</a>
                                    <h3>Import Data Mahasiswa</h3>
                                </div>
                                <form action="action.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Pilih Jurusan</label>
                                        <select name="jurusan" id="" class='form-control form-control-sm'>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdJurusan]>$jurusan[NamaJurusan]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pilih Jurusan</label>
                                        <select name="kelas" id="" class='form-control form-control-sm'>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdKelas]>$jurusan[NamaKelas]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Import Dari CSV</label>
                                        <input type="file" name='imp_mhs' class='form-control form-control-sm' required>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <input type="submit" name='import_mhs' class='btn btn-sm btn-success' value='Import'>
                                    <a href="?pg=mahasiswa" class='btn btn-sm btn-secondary'>Kembali</a>
                                </div>
                                </form>
                            </div>
                        <?php
                    }
                    elseif($_GET['act']=="migrasi")
                    {
                        ?>
                         <div class="card m-auto" style="width:23rem">
                                <div class="card-header">
                                    <h3 class='text-center'>Migrasi Data Mahasiswa Massal</h3>
                                </div>
                                <form action="action.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <div class="form-group">
                                        <label for="">Pilih Kelas Asal</label>
                                        <select name="kelas" id="" class='form-control form-control-sm'>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdKelas]>$jurusan[NamaKelas]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pilih Jurusan</label>
                                        <select name="jurusan" id="" class='form-control form-control-sm'>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdJurusan]>$jurusan[NamaJurusan]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pilih Kelas Tujuan</label>
                                        <select name="kelast" id="" class='form-control form-control-sm'>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdKelas]>$jurusan[NamaKelas]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <input type="submit" name='mig_mhs' class='btn btn-sm btn-success' value='Migrasi'>
                                    <a href="?pg=mahasiswa" class='btn btn-sm btn-secondary'>Kembali</a>
                                </div>
                                </form>
                            </div>
                        <?php
                    }
                    elseif($_GET['act']=='mhapus')
                    {
                        
                        ?>
                        <div class="card m-auto" style="width:23rem">
                            <div class="card-header">
                                Hapus Mahasiswa berdasarkan Kelas
                            </div>
                            <form action="action.php" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Pilih Kelas</label>
                                    <select name="kelas" id="" class='form-control form-control-sm'>
                                        <option value="">--</option>
                                        <?php
                                        $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                        while($jurusan = mysqli_fetch_array($jurusanQ))
                                        {
                                            echo "<option value=$jurusan[IdKelas]>$jurusan[NamaKelas]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                    <input type="submit" name='hapus_mmhs' class='btn btn-sm btn-success' value='Hapus'>
                                    <a href="?pg=mahasiswa" class='btn btn-sm btn-secondary'>Kembali</a>
                            </div>
                            </form>
                        </div>
                        <?php
                    }
                    elseif($_GET['act']=="tambah")
                    {
                        
                        ?>
                        <div class="card m-auto" style="width:30rem">
                        <div class="card-header"><h4 class="text-center">Tambah Data Mahasiswa</h4></div>
                        <form action="action.php" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">NIM :</label>
                                <input type="text" name="nim" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Mahasiswa :</label>
                                <input type="text" name="nama" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Jurusan</label>
                                <select name="jurusan" id="" class='form-control form-control-sm'>
                                    <option value="">--</option>
                                    <?php
                                    $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                    while($jurusan = mysqli_fetch_array($jurusanQ))
                                    {
                                        echo "<option value=$jurusan[IdJurusan]>$jurusan[NamaJurusan]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="" class='form-control form-control-sm'>
                                    <option value="">--</option>
                                    <?php
                                    $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                    while($jurusan = mysqli_fetch_array($jurusanQ))
                                    {
                                        $selected = ($mhs['IdKelas']==$jurusan['IdKelas']) ? 'selected' : '';
                                        echo "<option value=$jurusan[IdKelas] $selected>$jurusan[NamaKelas]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <input type="submit" name='tambah_mhs' class='btn btn-sm btn-success' value='Tambah'>
                            <a href="javascript:history.go(-1)" class='btn btn-sm btn-secondary'>Kembali</a>
                        </div>
                        </form>
                        </div>
                            <?php
                    }
                    elseif($_GET['act']=="edit")
                    {
                        $idm = $_GET['mid'];
                        $mhsQ = mysqli_query($connect, "SELECT * from tmahasiswa where IdMahasiswa = '$idm'");
                        $mhs = mysqli_fetch_array($mhsQ);
                        ?>
                        <div class="card m-auto" style="width:30rem">
                        <div class="card-header"><h4 class="text-center">Edit Data Mahasiswa</h4></div>
                        <form action="action.php" method="post">
                        <div class="card-body">
                            <div class="form-group">
                            <input type="hidden" name="idm" class="form-control form-control-sm" value="<?php echo $mhs['IdMahasiswa'] ?>">
                                <label for="">NIM :</label>
                                <input type="text" name="nim" class="form-control form-control-sm" value="<?php echo $mhs['NIM'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Mahasiswa :</label>
                                <input type="text" name="nama" class="form-control form-control-sm" value="<?php echo $mhs['NamaMahasiswa'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Jurusan</label>
                                <select name="jurusan" id="" class='form-control form-control-sm'>
                                    <option value="">--</option>
                                    <?php
                                    $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                    while($jurusan = mysqli_fetch_array($jurusanQ))
                                    {
                                        $selected = ($mhs['IdJurusan']==$jurusan['IdJurusan']) ? 'selected' : '';
                                        echo "<option value=$jurusan[IdJurusan] $selected>$jurusan[NamaJurusan]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="" class='form-control form-control-sm'>
                                    <option value="">--</option>
                                    <?php
                                    $jurusanQ = mysqli_query($connect, "SELECT * from tkelas");
                                    while($jurusan = mysqli_fetch_array($jurusanQ))
                                    {
                                        $selected = ($mhs['IdKelas']==$jurusan['IdKelas']) ? 'selected' : '';
                                        echo "<option value=$jurusan[IdKelas] $selected>$jurusan[NamaKelas]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <input type="submit" name='edit_mhs' class='btn btn-sm btn-success' value='Update'>
                            <a href="javascript:history.go(-1)" class='btn btn-sm btn-secondary'>Kembali</a>
                        </div>
                        </form>
                        </div>
                        <?php
                    }
                break;
                // manajemen mata kuliah
                case "mmakul":
                    if(!isset($_GET['act']))
                    {
                        $msg = '';
                        if(isset($_GET['msg'])){
                            if($_GET['msg']=="ts")
                            {
                                $msg =  "<div class='alert alert-success alert-sm'>Berhasil Tambah Data Mata Kuliah</div>";
                            }
                            elseif($_GET['msg']=="tg")
                            {
                                $msg =  "<div class='alert alert-danger alert-sm'>Gagal Tambah Data Mata Kuliah</div>";
                            }
                            elseif($_GET['msg']=="es")
                            {
                                $msg =  "<div class='alert alert-success alert-sm'>Berhasil Update Data Mata Kuliah</div>";
                            }
                            elseif($_GET['msg']=="eg")
                            {
                                $msg =  "<div class='alert alert-danger alert-sm'>Gagal Update Data Mata Kuliah</div>";
                            }
                        }
                        $sql = "SELECT * from tmakul";
                        $makulQ = mysqli_query($connect, $sql);
                    
                    ?>
                    <div class="container d-flex justify-content-center align-items-center flex-column">
                        <h3>List Mata Kuliah</h3>
                        <?php echo $msg ?>
                        <a href="?pg=mmakul&act=tambah" class="btn btn-primary m-3">Tambah Mata Kuliah</a>
                        <table class="table table-sm" id="tabel-nilai">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>Semester</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while($makul = mysqli_fetch_array($makulQ)) 
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $makul['NamaMakul']?></td>
                                        <td><?php echo $makul['Semester']?></td>
                                        <td>
                                            <a href="?pg=mmakul&act=edit&mid=<?php echo $makul['IdMakul']?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a onclick="return confirm yakin hapus data "href="?pg=mmakul&act=hapus&mid=<?php echo $makul['IdMakul']?>" class="btn btn-sm btn-danger">hapus</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    }
                    elseif($_GET['act']=="tambah")
                    {   
                            ?>
                            <div class="card m-auto" style="width:30rem">
                                <div class="card-header"><h4 class="text-center">Tambah Data mata Kuliah</h4></div>
                               <form action="action.php" method="post">
                               <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Jurusan</label>
                                        <select name="jurusan" id="" class='form-control form-control-sm' required>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {
                                                echo "<option value=$jurusan[IdJurusan]>$jurusan[NamaJurusan]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Semester</label>
                                        <select name="smt" id="" class="form-control form-control-sm" required>
                                            <?php
                                            for($i=1; $i<=8; $i++)
                                            {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kode Mata Kuliah</label>
                                        <input type="text" class="form-control form-control-sm" name="kdMakul" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Mata Kuliah</label>
                                        <input type="text" class="form-control form-control-sm" name="NamaMakul" required>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <input type="submit" name='tambah_makul' class='btn btn-sm btn-success' value='Tambah'>
                                    <a href="javascript:history.go(-1)" class='btn btn-sm btn-secondary'>Kembali</a>
                                </div>
                               </form>
                            </div>
                            <?php
                    }
                    elseif($_GET['act']=='edit')
                    {
                        $mid = $_GET['mid'];
                        $mkQ = mysqli_query($connect,"SELECT * from tmakul where IdMakul='$mid'");
                        $mk = mysqli_fetch_array($mkQ);
                        ?>
                        <div class="card m-auto" style="width:30rem">
                                <div class="card-header"><h4 class="text-center">Edit Data mata Kuliah</h4></div>
                               <form action="action.php" method="post">
                                <input type="hidden" value="<?php echo $mid ?>" name="mid">
                               <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Jurusan</label>
                                        <select name="jurusan" id="" class='form-control form-control-sm' required>
                                            <option value="">--</option>
                                            <?php
                                            $jurusanQ = mysqli_query($connect, "SELECT * from tjurusan");
                                            while($jurusan = mysqli_fetch_array($jurusanQ))
                                            {   
                                                $sel = ($jurusan['IdJurusan']== $mk['IdJurusan']) ? 'selected' : '';
                                                echo "<option value=$jurusan[IdJurusan] $sel>$jurusan[NamaJurusan]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Semester</label>
                                        <select name="smt" id="" class="form-control form-control-sm" required>
                                            <?php
                                            for($i=1; $i<=8; $i++)
                                            {
                                                $sel = ($i== $mk['Semester']) ? 'selected' : '';
                                                echo "<option value='$i' $sel>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kode Mata Kuliah</label>
                                        <input type="text" class="form-control form-control-sm" name="KdMakul" value="<?php echo $mk['KdMakul']?>"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Mata Kuliah</label>
                                        <input type="text" class="form-control form-control-sm" name="NamaMakul" value="<?php echo $mk['NamaMakul']?>" required>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <input type="submit" name='edit_makul' class='btn btn-sm btn-success' value='Update'>
                                    <a href="javascript:history.go(-1)" class='btn btn-sm btn-secondary'>Kembali</a>
                                </div>
                               </form>
                            </div>
                        <?php
                    }
                break;

                //manajemen dosen
                // case "dosen" :
                //     echo "manajemen dosen";
                // break;

                // manajemen transkrip nilai
                case "transkrip":
                    if(!isset($_GET['act']))
                    {
                        echo "tidak ada menu dipilih";
                    }
                    elseif($_GET['act']=='nilai')
                    {
                        $kelasQ = mysqli_query($connect, "SELECT * from tkelas");
                        $cetak="";
                        $ket = "";
                        if(isset($_POST['kelas']))
                        {
                            $kelas = $_POST['kelas'];
                            $trans = mysqli_num_rows(mysqli_query($connect,"SELECT * from ttranskrip_nilai where id_kelas = '$kelas' and id_ta = '$ta_id' and jenis=$jenis"));
                            $mhs = mysqli_num_rows(mysqli_query($connect,"SELECT * from tmahasiswa where IdKelas = '$kelas'"));
                            $test = mysqli_num_rows(mysqli_query($connect,"SELECT * from ttest where id_kelas = '$kelas' and id_ta = '$ta_id'"));
                            if($trans > 0)
                            {
                                $tottrans = $trans / $test;
                                if($tottrans !== $mhs)
                                {
                                    $ket="<div class='alert alert-warning alert-sm'>Masih Terdapat Data Nilai Mahasiswa yang belum terisi, silahkan lengkapi di menu <b>Validasi Nilai 0</b></div>";
                                }
                                else
                                {
                                    $ket = "<div class='alert alert-sm alert-info'>Semua Data Nilai Mahasiswa telah Divalidasi</div>";
                                    $cetak = "<div class='card-footer text-center'>
                                            <a href='cetak_trans.php?idk=$kelas&pid=$sid&taid=$ta_id&jn=$jenis' class='btn btn-sm btn-danger' target='_blank'>Cetak PDF</a>
                                            <a href='excel_trans.php?idk=$kelas&pid=$sid&taid=$ta_id&jn=$jenis' class='btn btn-sm btn-success' target='_blank'>Download Excel</a>
                                        </div>";
                                }

                            }
                            else
                            {
                                $ket = "<div class='alert alert-sm alert-secondary'>Belum Ada Data Nilai Yang Diinput Untuk Kelas berikut</div>";
                            }
                            
                            
                        }
                        
                        ?>
                        <div class="container d-flex flex-column justify-content-center align-items-center">
                            <?= $ket ?>
                            <div class="card" style="width:23rem">
                                <div class="card-header">
                                    <h3>Rekap Nilai Mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="">Pilih Kelas</label>
                                        <select name="kelas" id="" class='form-control form-control-sm' onchange="this.form.submit()">
                                            <option value="">--</option>
                                            <?php
                                                while($kelas = mysqli_fetch_array($kelasQ))
                                                {
                                                    $selected = (isset($_POST['kelas']) && $_POST['kelas'] == $kelas['IdKelas']) ? 'selected' :'';
                                                    echo "<option value='$kelas[IdKelas]' $selected>$kelas[NamaKelas]</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                                </div>
                                <?php echo $cetak ?>
                            </div>
                            
                        </div>
                        <?php
                    }
                    elseif($_GET['act']=="de")
                    {
                        $kelasQ = mysqli_query($connect, "SELECT * from tkelas");
                        $cetak="";
                        $ket = "";
                        if(isset($_POST['kelas']))
                        {
                            $kelas = $_POST['kelas'];
                            $trans = mysqli_num_rows(mysqli_query($connect,"SELECT * from ttranskrip_nilai where id_kelas = '$kelas' and id_ta = '$ta_id' and jenis=$jenis"));
                            $mhs = mysqli_num_rows(mysqli_query($connect,"SELECT * from tmahasiswa where IdKelas = '$kelas'"));
                            $test = mysqli_num_rows(mysqli_query($connect,"SELECT * from ttest where id_kelas = '$kelas' and id_ta = '$ta_id'"));
                            if($trans > 0)
                            {
                                $tottrans = $trans / $test;
                                if($tottrans !== $mhs)
                                {
                                    $ket="<div class='alert alert-warning alert-sm'>Masih Terdapat Data Nilai Mahasiswa yang belum terisi, silahkan lengkapi di menu <b>Validasi Nilai 0</b></div>";
                                }
                                else
                                {
                                    $ket = "<div class='alert alert-sm alert-info'>Semua Data Nilai Mahasiswa telah Divalidasi</div>";
                                    $cetak = "<div class='card-footer text-center'>
                                            <a href='cetak_de.php?idk=$kelas&pid=$sid&taid=$ta_id&jn=$jenis' class='btn btn-sm btn-danger' target='_blank'>Cetak PDF</a>
                                            <a href='excel_de.php?idk=$kelas&pid=$sid&taid=$ta_id&jn=$jenis' class='btn btn-sm btn-success' target='_blank'>Download Excel</a>
                                        </div>";
                                }

                            }
                            else
                            {
                                $ket = "<div class='alert alert-sm alert-secondary'>Belum Ada Data Nilai Yang Diinput Untuk Kelas berikut</div>";
                            }
                            
                            
                        }
                        ?>
                        <div class="container d-flex flex-column justify-content-center align-items-center">
                        <?= $ket ?>
                            <div class="card" style="width:23rem">
                                <div class="card-header">
                                    <h3>Rekap Nilai D & E</h3>
                                </div>
                                <div class="card-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="">Pilih Kelas</label>
                                        <select name="kelas" id="" class='form-control form-control-sm' onchange="this.form.submit()">
                                            <option value="">--</option>
                                            <?php
                                                while($kelas = mysqli_fetch_array($kelasQ))
                                                {
                                                        $selected = (isset($_POST['kelas']) && $_POST['kelas'] == $kelas['IdKelas']) ? 'selected' :'';
                                                    echo "<option value='$kelas[IdKelas]' $selected>$kelas[NamaKelas]</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                                </div>
                                <?php echo $cetak ?>
                            </div>
                            
                        </div>
                        <?php
                    }
                    if($_GET['act']=="nol")
                    {
                        if(isset($_POST['kelas']) || isset($_GET['idk']))
                        {
                            $kelas = (isset($_GET['idk'])) ? $_GET['idk'] : $_POST['kelas'];
                            $mhsQ = mysqli_query($connect, "SELECT * from tmahasiswa where IdKelas = '$kelas'");    
                            $cetak = "<a href='excel_nol.php?idk=$kelas&taid=$ta_id' class='btn btn-sm btn-success mr-3'>Cetak Excel</a>";    
                        }
                        ?>
                        <h3>Validasi Mahasiswa Yang Tidak Ikut Ujian</h3>
                        <form action="" method="post">
                            <div class="form-inline">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="" class='form-control form-control-sm ml-3 mr-3' onchange="this.form.submit()">
                                            <option value="">--</option>
                                            <?php
                                                $kelasQ = mysqli_query($connect, "SELECT * from tkelas");
                                                while($kelas = mysqli_fetch_array($kelasQ))
                                                {
                                                        $selected = (isset($_POST['kelas']) && $_POST['kelas'] == $kelas['IdKelas']) ? 'selected' :'';
                                                    echo "<option value='$kelas[IdKelas]' $selected>$kelas[NamaKelas]</option>";
                                                }
                                            ?>
                                </select>
                                <?= $cetak ?>
                            </div>
                            <table class="table table-sm table-bordered" id=<?php echo ($mhsQ) ?"tabel-nilai" : "" ?>>
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
                                    while($mhs = mysqli_fetch_array($mhsQ)) {
                                        $nim = $mhs['NIM'];
                                        $nama = $mhs['NamaMahasiswa'];
                                        $id = $mhs['IdMahasiswa'];
                                        $kelas = $mhs['IdKelas'];
                                        $testQ = mysqli_query($connect, "SELECT ttest.*, tmakul.NamaMakul 
                                        from ttest 
                                        left join tmakul on tmakul.IdMakul = ttest.makul
                                        where ttest.id_kelas = '$kelas' and ttest.id_ta = '$ta_id'");
                                        while($test=mysqli_fetch_array($testQ))
                                        {
                                            $makul = $test['makul'];
                                            $namamakul = $test['NamaMakul'];
                                        $transuas = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '2' and id_ta = '$ta_id' and nilai = 0 and id_makul = '$makul'");
                                        $transuts = mysqli_query($connect, "SELECT * from ttranskrip_nilai  where nim = '$nim' and jenis = '1' and id_ta = '$ta_id' and nilai = 0 and id_makul = '$makul'");
                                            if(mysqli_num_rows($transuas) > 0 || mysqli_num_rows($transuts) > 0)
                                            {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $nim ?></td>
                                            <td><?= $nama ?></td>
                                            <!-- <td><?= $namamakul?></td> -->
                                            <td><?= (mysqli_num_rows($transuts) > 0) ? $namamakul : null?></td>
                                            <td><?= (mysqli_num_rows($transuas) > 0) ? $namamakul : null?></td>
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
                        </form>
                        <?php
                    }
                    
                    
                break;
                case "uprak":
                    if(!isset($_GET['act']))
                    {
                        if(isset($_POST['kelas']) || isset($_GET['idk']))
                        {
                            $kelass =(isset($_GET['idk'])) ?$_GET['idk'] :$_POST['kelas'];
                        $sql = ($jenis==2)  
                        ?"SELECT ttest.*,
                        tkelas.NamaKelas,  tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas = '$kelass' order by ttest.status ASC"
                        : "SELECT ttest.*,
                        tkelas.NamaKelas,  tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' and ttest.id_kelas = '$kelass' order by ttest.status_uts ASC";
                        }
                        else
                        {
                        $sql = ($jenis==2) 
                        ?"SELECT ttest.*,
                        tkelas.NamaKelas, tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' order by ttest.status ASC"
                        :  "SELECT ttest.*,
                        tkelas.NamaKelas, tmakul.NamaMakul
                        from ttest
                        left join tkelas on tkelas.IdKelas = ttest.id_kelas
                        left join tmakul on tmakul.IdMakul = ttest.makul where ttest.id_ta='$ta_id' order by ttest.status_uts ASC";  
                        }
                        $query = mysqli_query($connect, $sql);

                        ?>
                        <div class="container d-flex flex-column align-items-center">
                            <div class="tambah w-100 mb-3 d-flex justify-content-between"><h4>List Mata Kuliah Test</h4>
                                <span>
                                    <a href="?pg=makul&act=tambah" class="btn btn-sm btn-success">Tambah Test</a>
                                    <a href="?pg=uprak" class="btn btn-sm btn-info">Tampilkan Semua Data</a>
                                </span>
                            </div>
                            <form action="" method="post">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" id="makuls" class='form-control form-control-sm mb-3' onchange='this.form.submit()'>
                                    <option value="">--</option>
                                    <?php
                                    $kelasQ = mysqli_query($connect, "SELECT * from tkelas");
                                    while($kelas = mysqli_fetch_array($kelasQ))
                                    {
                                        echo "<option value='$kelas[IdKelas]'>$kelas[NamaKelas]</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                            <table class="table table-bordered w-100" id=<?php echo (mysqli_num_rows($query)>0) ?"tabel-nilai" : "";?>>
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <!-- <th>Dosen</th> -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    if(mysqli_num_rows($query)>0)
                                    {
                                        $i=1;
                                        while($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr style="background:<?php echo ($row['uprak'] == 1) ? 'aqua' : '' ?>">
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['NamaMakul'] ?></td>
                                            <td><?php echo $row['NamaKelas'] ?></td>
                                            <!-- <td><?php echo $row['Nama'] ?></td> -->
                                            <td><?php 
                                            if($row['status']==1 && $row['status_uts']==1)
                                            {
                                            echo ($row['uprak']==0)? "<a href = '?pg=nilai&idt=$row[id_test]&idk=$row[id_kelas]&idm=$row[makul]&uprak=uprak' class='btn btn-sm btn-info'>Upload Data</a>" 
                                                
                                                : "<a onclick='return confirm(`yakin hapus data $row[NamaMakul] ?`)' href='action.php?delt=$row[id_test]&jenis=3' class='btn btn-sm btn-secondary'>Hapus Data Tes</a>
                                                <a href='cetak_mkl.php?tid=$row[id_test]&idk=$row[id_kelas]&jenis=3' class='btn btn-sm btn-light' target='__blank'>Cetak Data</a>
                                                ";
                                            }
                                            else
                                            {
                                                echo "Belum UTS/UAS";
                                            }
                                             ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    }
                                    else { 
                                        
                                    ?>
                                        <tr>
                                            <td>Data Tidak Ditemukan</td>
                                        </tr>
                                    <?php  }?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                break;
                case "rev" :
                    if(isset($_POST['lnilai']))
                    {
                        $nim = $_POST['nim'];
                        $mhsQ = mysqli_query($connect,"SELECT tmahasiswa.*, tkelas.NamaKelas 
                        from tmahasiswa
                        left join tkelas on tkelas.IdKelas = tmahasiswa.IdKelas
                        where NIM='$nim'");
                        $mhs = mysqli_fetch_array($mhsQ);
                        $idk = $mhs['IdKelas'];
                        $kelas = $mhs['NamaKelas'];
                        $nama = $mhs['NamaMahasiswa'];
                        $nimm = $mhs['NIM'];

                        $testQ = mysqli_query($connect, "SELECT ttest.*, tmakul.NamaMakul
                        from ttest 
                        left join tmakul on ttest.makul = tmakul.IdMakul
                        where id_kelas = '$idk' and id_ta = '$ta_id'");
                    }
                    ?>
                    <h3>Perbaikan Nilai</h3>
                    <div class="card w-50 m-auto">
                        <div class="card-header">Perbaikan Nilai</div>
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">NIM</label>
                                    <input type="text" name="nim" id="" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <input type="submit" value="Lihat Nilai" name='lnilai' class="btn btn-sm btn-primary">
                            </div>
                        </form>
                    </div>
                   <table class="w-50 my-4">
                   <tr>
                        <th>Nim</th>
                        <td>: <?= $nimm?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>: <?= $nama?></td>
                    </tr>
                    <tr>
                        <th>Jurusan/Angkatan</th>
                        <td>: <?= $kelas ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Akademik</th>
                        <td>: <?= $periode ?></td>
                    </tr>
                   </table>
                   <p>Klik Pada Nilai Uprak Untuk Melakukan Perbaikan *)</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Mata Kuliah</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>UPRAK</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!$testQ)
                            {
                                echo "<tr><td>Masukkan NIM untuk melihat nilai</td></tr>";
                               
                            }
                            else
                            {
                            $no = 1;
                                while($test = mysqli_fetch_array($testQ))
                                {
                                    $idmak = $test['makul'];
                                    $transuts = mysqli_query($connect, "SELECT * from ttranskrip_nilai where id_makul = '$idmak' and jenis = 1 and nim ='$nimm' ");
                                    $transuas = mysqli_query($connect, "SELECT * from ttranskrip_nilai where id_makul = '$idmak' and jenis = 2 and nim ='$nimm'");
                                    $transuprak = mysqli_query($connect, "SELECT * from ttranskrip_nilai where id_makul = '$idmak' and jenis = 3 and nim ='$nimm'");
                                    if(mysqli_num_rows($transuts)>0 && mysqli_num_rows($transuts)>0)
                                    {
                                        $tuts = mysqli_fetch_array($transuts);
                                        $tuas = mysqli_fetch_array($transuas);
                                        $tupr = mysqli_fetch_array($transuprak);
                                        $nuts = $tuts['nilai'];
                                        $nuas = $tuas['nilai'];
                                        $nupr = $tupr['nilai'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $test['NamaMakul'] ?></td>
                                        <?php
                                        if($nuts==0)
                                        {
                                        ?>
                                        <td><a href="#" class="edit-link"data-toggle="modal" data-target="#modaleditnilai" data-makul = '<?= $test['NamaMakul'] ?>'  data-nilai = '<?= $nuts ?>' data-jenis="1" data-idtr='<?=$tuts['id_transkrip']?>'><?= $nuts ?></a></td>
                                        <?php }else{
                                            echo "<td>$nuts</td>";
                                        }
                                        if($nuas==0)
                                        {
                                        ?>
                                        <td><a href="#" class="edit-link" data-toggle="modal" data-target="#modaleditnilai" data-makul = '<?= $test['NamaMakul'] ?>' data-nilai = '<?= $nuas ?>' data-jenis="2" data-idtr='<?=$tuas['id_transkrip']?>'><?= $nuas ?></a></td>
                                        <?php
                                        } else
                                        {
                                        echo "<td> $nuas</td>";
                                        } 
                                        ?>
                                        <td><?= (mysqli_num_rows($transuprak)>0) ? "<a href='#' class='edit-link' data-toggle='modal' data-target='#modaleditnilai' data-makul = '$test[NamaMakul]' data-nilai='$nupr' data-jenis='3' data-idtr='$tupr[id_transkrip]'>$nupr</a>" : "Tidak Ada Uprak" ?></td>
                                    </tr>
                                    <?php
                                    
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                    <div class="modal" id="modaleditnilai" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Nilai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="action.php" method="post">
                            <input type="hidden" name="nl_idtr" id="edn_idtr" >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Mata Kuliah</label>
                                <input type="text" name="nl_makul" id="edn_mkl" class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nilai Sekarang</label>
                                <input type="text" name="nl_n" id="edn_nl" class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nilai Update</label>
                                <input type="number" name="nl_u" class="form-control form-control-sm" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="nl_update" class="btn btn-primary" value="Update">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <?php

                break;
                
            }
        }
            ?>
            </div>
            <div class="footer">
                <h5>&copy; Wijaya Husada 2023</h5>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    
  

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../assets/script.js"></script>
<script>
    document.getElementById('makuls').value = "<?php echo $kelass;?>";
    


    
</script>
<!-- Menu Toggle Script -->

</body>
</html>