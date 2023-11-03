<?php
require '../connection.php';
require_once '../function.php';
if(isset($_POST['tambah_test']))
{
    $makul = filter_var($_POST['KdMakul'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    $dosen = filter_var($_POST['KdDosen'], FILTER_SANITIZE_STRING);
    $sheets= filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
    $sql = "INSERT into ttest values ('','$makul','$jurusan','$dosen','$sheets')";
    $query = mysqli_query($connect, $sql);
    echo ($query) ? "<script>alert('Berhasil Tambah Data'); window.location = 'dashboard.php?pg=makul';</script>" 
                  : "<script>alert('Gagal Tambah Data'); window.location = 'dashboard.php?pg=makul';</script>";
}
if(isset($_POST['update_test']))
{
    $id = filter_var($_POST['id_test'], FILTER_SANITIZE_STRING);
    $makul = filter_var($_POST['KdMakul'], FILTER_SANITIZE_STRING);
    $jurusan = filter_var($_POST['jurusan'], FILTER_SANITIZE_STRING);
    $dosen = filter_var($_POST['KdDosen'], FILTER_SANITIZE_STRING);
    $sheets= filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
    $sql = "UPDATE  ttest set id_jurusan = '$jurusan', makul = '$makul', dosen = '$dosen', sheets_id = '$sheets' where id_test = '$id'";
    $query = mysqli_query($connect, $sql);
    echo ($query) ? "<script>alert('Berhasil Update Data'); window.location = 'dashboard.php?pg=makul';</script>" 
                  : "<script>alert('Gagal Update Data'); window.location = 'dashboard.php?pg=makul';</script>";
}
?>