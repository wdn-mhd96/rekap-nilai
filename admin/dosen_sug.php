<?php
require '../connection.php';
require_once '../function.php';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = mysqli_query($connect,"SELECT * from tdosen");

    while ($suggestion = mysqli_fetch_array($sql)) {
        if (stripos($suggestion['Nama'], $search) !== false) {
            echo "<li><a class='sugdosen' data-kd='".$suggestion['IdDosen']."'>" .$suggestion['Nama'] . "</a>/li>";
        }
    }
}
if (isset($_POST['makul'])) {
    $search = $_POST['makul'];
    $sql = mysqli_query($connect,"SELECT * from tmakul");

    while ($suggestion = mysqli_fetch_array($sql)) {
        if (stripos($suggestion['NamaMakul'], $search) !== false) {
            echo "<li><a class=sugmakul data-id='".$suggestion['IdMakul']."'>" . $suggestion['NamaMakul'] . "</a></li>";
        }
    }
}

if (isset($_POST['sheets'])) {
    $sheets = filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
    $sql = mysqli_query($connect,"SELECT * from ttest where sheets_id='$sheets'");
    if(mysqli_num_rows($sql)>0) {
        echo "<div class='alert-sm alert-danger'>Link Sudah Ada</div>";
    }
    else {
        if($sheets=="")
        {
            echo "<div class='alert-sm alert-danger'>Link Tida Boleh Kosong</div>";
        }
        else
        {
            echo "<div class='alert-sm alert-success'>Link Bisa Di upload</div>";
        }
    }
}
?>