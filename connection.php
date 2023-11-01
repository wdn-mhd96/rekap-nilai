<?php 
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'akbg4984_stikeswhdb';
$connect = mysqli_connect($hostname,$username,$password, $db);
if(!$connect) {
    echo "Koneksi Gagal";
}