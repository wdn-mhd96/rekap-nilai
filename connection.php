<?php 
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'db_nilai';
$connect = mysqli_connect($hostname,$username,$password, $db);
if(!$connect) {
    echo "Koneksi Gagal";
}