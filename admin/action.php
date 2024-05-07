<?php
require '../connection.php';
require_once '../function.php';
if(isset($_POST['tambah_test']))
{
    $makul = filter_var($_POST['KdMakul'], FILTER_SANITIZE_STRING);
    $sid = filter_var($_POST['periode'], FILTER_SANITIZE_STRING);
    $ta_id = filter_var($_POST['ta'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    // $dosen = filter_var($_POST['KdDosen'], FILTER_SANITIZE_STRING);
    $sheets= filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
    $sql = "INSERT into ttest values ('','$makul','$jurusan','0','0','0','$sid', $ta_id)";
    $query = mysqli_query($connect, $sql);
    echo ($query) ? "<script>alert('Berhasil Tambah Data'); window.history.go(-1);</script>" 
                  : "<script>alert('Gagal Tambah Data'); window.history.go(-1)';</script>";
}
if(isset($_POST['update_test']))
{
    $id = filter_var($_POST['id_test'], FILTER_SANITIZE_STRING);
    $makul = filter_var($_POST['KdMakul'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    // $dosen = filter_var($_POST['KdDosen'], FILTER_SANITIZE_STRING);
    $sheets= filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
    $sql = "UPDATE  ttest set id_kelas = '$jurusan', makul = '$makul' where id_test = '$id'";
    $query = mysqli_query($connect, $sql);
    echo ($query) ? "<script>alert('Berhasil Update Data'); window.location = 'dashboard.php?pg=makul';</script>" 
                  : "<script>alert('Gagal Update Data'); window.location = 'dashboard.php?pg=makul';</script>";
}


if(isset($_POST['tambah_periode']))
{
    


    $tahun = $_POST['tahun'];
    $jenis = (int)$_POST['jenis'];
    $terpilih = (isset($_POST['pilih'])) ? 1 : 0;


    $prdQ = mysqli_query($connect, "SELECT * from tperiode where terpilih=1");
    $prd = mysqli_fetch_array($prdQ);
    $sid = $prd['id_periode'];
    if(mysqli_num_rows($prdQ)>0){
        if(isset($_POST['pilih'])) {
        mysqli_query($connect, "UPDATE tperiode set terpilih=0 where id_periode='$sid'");
        }
    }
    $query = mysqli_query($connect,"INSERT into tperiode values('', '$tahun','$jenis','$terpilih')");

    echo ($query) ? "<script>alert('Berhasil Update Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>" 
                  : "<script>alert('Gagal Update Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>";
}

switch($_GET['prd'])
{
    case "ganti":
        if(!isset($_GET['pid']) || !isset($_GET['sid']))
        {
            echo "Unknown Method";
        }
       else {
        $pid = $_GET['pid'];
       $sid = $_GET['sid'];
       $updatep = mysqli_query($connect, "UPDATE tperiode set terpilih=1 where id_periode='$pid'");
       $updates = mysqli_query($connect, "UPDATE tperiode set terpilih=0 where id_periode='$sid'");
       echo ($updatep && $updates) ? "<script>alert('Berhasil Update Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>" 
                  : "<script>alert('Gagal Update Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>";
       }
    break;
    case "del":
        if(!isset($_GET['pid']) || !isset($_GET['sid']))
        {
            echo "Unknown Method";
            return;
        }
        $pid = $_GET['pid'];
        $sid = $_GET['sid'];
        if($pid == $sid){
            echo "<script>alert('tidak bisa hapus periode terpilih'); window.history.go(-1);</script>";
        }
        else {

        $delp = mysqli_query($connect, "DELETE from tperiode where id_periode = '$pid'");
        echo ($delp) ? "<script>alert('Berhasil hapus Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>" 
                  : "<script>alert('Gagal hapus Data'); window.location = 'dashboard.php?pg=periode&act=ganti';</script>";
        }
    break;
}
if(isset($_POST['tambah_tahun']))
{
    $tahun = $_POST['tahun'];
    $gg = $_POST['gg'];
    $ta = $tahun . " - ". $gg;
    $tambahta = mysqli_query($connect, "INSERT into ttahun values('','$ta')");
    echo ($tambahta) ? "<script>alert('Berhasil Tambah Data'); window.location = 'dashboard.php?pg=periode&act=tambah';</script>" 
                    : "<script>alert('Gagal Tambah Data'); window.location = 'dashboard.php?pg=periode&act=tambah';</script>";
}

// menu mahasiswa
if(isset($_POST['import_mhs']))
{
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
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
    if(!empty($_FILES['imp_mhs']['name']) && in_array($_FILES['imp_mhs']['type'],$filetype))
    {
        $csvfile = fopen($_FILES['imp_mhs']['tmp_name'], 'r');
        $header = fgetcsv($csvfile);
        $succ = 0;
        while($row = fgetcsv($csvfile,10000,','))
        {
            $nim = $row[1];
            $nama = $nama = htmlspecialchars_decode(html_entity_decode($row[2]));
            $mhsQ =mysqli_num_rows(mysqli_query($connect, "SELECT NIM from tmahasiswa where NIM = '$nim'"));
            if($nim !== null && $nama !== null && $mhsQ == 0)
            {
                $succ +=$succ;
                $query = mysqli_query($connect, "INSERT into tmahasiswa values ('','$nim','$nama','$jurusan','$kelas')");
                echo ($query) ? "<script>alert('Berhasil Import $succ Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=suc&suc=$succ';</script>" 
                : "<script>alert('Gagal Import Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=fail';</script>";
                
            }
        }
        fclose($csvfile);
    }
}
if(isset($_POST['mig_mhs']))
{
    $kls = $_POST['kelas'];
    $jrs = $_POST['jurusan'];
    $klst = $_POST['kelast'];

    $query = mysqli_query($connect,"UPDATE tmahasiswa set IdKelas = '$klst' where IdJurusan ='$jrs' and IdKelas = $kls");
                echo ($query) ? "<script>alert('Berhasil Migrasi Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa';</script>" 
                        : "<script>alert('Gagal Migrasi Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa';</script>";
                
}

if(isset($_POST['hapus_mmhs']))
{
    $kelas = $_POST['kelas'];
    $query = mysqli_query($connect,"DELETE from tmahasiswa where IdKelas = '$kelas'");
                echo ($query) ? "<script>alert('Berhasil Hapus Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=mhapuss';</script>" 
                        : "<script>alert('Gagal Hapus Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=mhapusg';</script>";

}

if(isset($_POST['edit_mhs']))
{
    
    $idm = filter_var($_POST['idm'], FILTER_SANITIZE_STRING);
    $nim = filter_var($_POST['nim'], FILTER_SANITIZE_STRING);
    $nama = filter_var($_POST['nama'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    $kelas = filter_var($_POST['kelas'], FILTER_SANITIZE_STRING);

    $query = mysqli_query($connect, "UPDATE tmahasiswa set NIM = '$nim', NamaMahasiswa = '$nama', IdJurusan = '$jurusan', IdKelas = '$kelas' where IdMahasiswa = '$idm'");
    echo ($query) ? "<script>alert('Berhasil Update Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=editms';</script>" 
    : "<script>alert('Gagal Update Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=editmg';</script>";
}
if(isset($_POST['tambah_mhs']))
{
    
    // $idm = filter_var($_POST['idm'], FILTER_SANITIZE_STRING);
    $nim = filter_var($_POST['nim'], FILTER_SANITIZE_STRING);
    $nama = filter_var($_POST['nama'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    $kelas = filter_var($_POST['kelas'], FILTER_SANITIZE_STRING);
    
    $mhsQ =mysqli_num_rows(mysqli_query($connect, "SELECT NIM from tmahasiswa where NIM = '$nim'"));
    if($mhsQ > 0)
    {
        echo "<script>alert('NIM Sudah Ada pada Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=editmg';</script>";
    }
    else
    {
    $query = mysqli_query($connect, "INSERT into  tmahasiswa values ('','$nim','$nama','$jurusan','$kelas')");
    echo ($query) ? "<script>alert('Berhasil tambah Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=editms';</script>" 
    : "<script>alert('Gagal tambah Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=editmg';</script>";
    }
}

if(isset($_GET['mhs']))
{
    if($_GET['mhs']=="hapus")
    {
        $idm = $_GET['mid'];
        $query = mysqli_query($connect,"DELETE from tmahasiswa where IdMahasiswa ='$idm'");
        echo ($query) ? "<script>alert('Berhasil Hapus Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=hapusms';</script>" 
        : "<script>alert('Gagal Hapus Data Mahasiswa'); window.location = 'dashboard.php?pg=mahasiswa&msg=hapusmg';</script>";

    }
}

// menu mata kuliah
if(isset($_POST['tambah_makul']))
{
    $jurusan = filter_var($_POST['jurusan'],FILTER_SANITIZE_STRING);
    $smt = filter_var($_POST['smt'],FILTER_SANITIZE_STRING);
    $KdMakul = filter_var($_POST['KdMakul'],FILTER_SANITIZE_STRING);
    $NamaMakul = filter_var($_POST['NamaMakul'],FILTER_SANITIZE_STRING);
    $query = mysqli_query($connect, "INSERT into tmakul values('','$KdMakul','$NamaMakul','$smt','$jurusan')");
    echo ($query) ? "<script>alert('Berhasil Tambah Data Mata Kuliah'); window.history.go(-1);</script>" 
    : "<script>alert('Gagal Tambah Data Mahasiswa'); window.history.go(-1);</script>";

}
if(isset($_POST['edit_makul']))
{
    
    $mid = filter_var($_POST['mid'],FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'],FILTER_SANITIZE_STRING);
    $smt = filter_var($_POST['smt'],FILTER_SANITIZE_STRING);
    $KdMakul = filter_var($_POST['KdMakul'],FILTER_SANITIZE_STRING);
    $NamaMakul = filter_var($_POST['NamaMakul'],FILTER_SANITIZE_STRING);
    
    $query = mysqli_query($connect, "UPDATE tmakul set IdJurusan = '$jurusan', Semester = '$smt', KdMakul = '$KdMakul', NamaMakul = '$NamaMakul' where IdMakul = '$mid'");
    echo ($query) ? "<script>alert('Berhasil Update Data Mata Kuliah'); window.location = 'dashboard.php?pg=mmakul&msg=es';</script>" 
    : "<script>alert('Gagal Update Data Mata Kuliah'); window.location = 'dashboard.php?pg=mmakul&msg=eg';</script>";

}

if(isset($_GET['delt']))
{
    $tid = $_GET['delt'];
    $jn = $_GET['jenis'];
    ($jenis==2)

    ? mysqli_query($connect,"UPDATE ttest set status=0 where id_test='$tid'")
    : mysqli_query($connect,"UPDATE ttest set status_uts=0 where id_test='$tid'");
    
    $query = mysqli_query($connect,"DELETE from ttranskrip_nilai where id_test='$tid' and jenis='$jn'");
    echo ($query) ? "<script>alert('Berhasil Hapus Data Test'); window.location = 'dashboard.php?pg=makul';</script>" 
    : "<script>alert('Gagal Hapus Data Test'); window.location = 'dashboard.php?pg=makul';</script>";

}

// validasi nilai 0
if(isset($_GET['valid']))
{
    if($_GET['valid']=="v")
    {
        $nim = $_GET['idm'];
        $kelas = $_GET['idk'];
        $pid = $_GET['pid'];
        $testQ = mysqli_query($connect,"SELECT * from ttest where id_kelas='$kelas' and id_periode = '$pid'");
        while($test = mysqli_fetch_array($testQ))
        {
            $makul = $test['makul'];
            $idt = $test['id_test'];
            $transQ = mysqli_query($connect, "SELECT * from ttranskrip_nilai where nim = '$nim' and id_test='$idt'");
            if(mysqli_num_rows($transQ)>0)
            {
            //     $query = mysqli_query($connect,"INSERT into ttranskrip_nilai values ('','$idt','$kelas','$pid','$makul','$nim',0)");
            //     echo ($query) ? "<script>alert('Berhasil Validasi Data'); window.location = 'dashboard.php?pg=transkrip&act=nol&idk=$kelas';</script>" 
            //     : "<script>alert('Gagal Validasi Data'); window.location = 'dashboard.php?pg=transkrip&act=nol&idk=$kelas';</script>";
            var_dump($makul);
            }
        }
    }
}

// update nilai
if(isset($_POST['nl_update']))
{
    $idtr = $_POST['nl_idtr'];
    $nilai = $_POST['nl_u'];
    $query= mysqli_query($connect, "UPDATE ttranskrip_nilai set nilai = '$nilai' where id_transkrip = '$idtr'");
    echo ($query) ? "<script>alert('Berhasil Update Data Nilai'); window.location = 'dashboard.php?pg=rev';</script>" 
    : "<script>alert('Gagal Update Data Nilai'); window.location = 'dashboard.php?pg=rev';</script>";
}
?>