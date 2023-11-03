<?php
require '../connection.php';
require '../function.php';
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
        <div class="nav-bar w-100">
            <a href="#menu-toggle" class="text-light" id="menu-toggle">X</a>
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
                    <a href="?pg=nilai" class="menu-link">Nilai</a>
                </li>
                <li>
                    <a href="?pg=makul" class="menu-link">Tambah Test</a>
                </li>
                <li>
                    <a href="?pg=transkrip" class="menu-link">Transkrip</a>
                </li>
                <li>
                    <!-- <a href="?pg=prodi" class="menu-link">Prodi</a> -->
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
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
                case "nilai":
                    if (isset($_POST['makul'])) {
                        $link = filter_var($_POST['makul'], FILTER_SANITIZE_STRING);
                       $result = get_json($link);
                       $data = $result['data'];
                       $prodi = $result['prodi'];
                       $tingkat = $result['tingkat'];
                        $sql = "SELECT *,tmakul.NamaMakul, tdosen.Nama from ttest
                                left join tmakul on tmakul.IdMakul = ttest.makul
                                left join tdosen on tdosen.IdDosen = ttest.dosen  where sheets_id='$link'";
                        $query = mysqli_query($connect, $sql);
                        $testQ = mysqli_fetch_array($query);
                        $judul = $testQ['NamaMakul'] . " - " . $testQ['Nama'];
                    }
                    
                    if(isset($_POST['filter']))
                        {
                        $link = filter_var($_POST['sheets'], FILTER_SANITIZE_STRING);
                       $fprodi = $_POST['prodi'];
                       $ftingkat = $_POST['tingkat'];
                        $result = get_json($link);
                       $dataa = $result['data'];
                       $prodi = $result['prodi'];
                       $tingkat = $result['tingkat'];
                       $data = array_filter($dataa, function($item) use ($fprodi, $ftingkat){
                        return $item['Prodi'] == $fprodi && $item['tingkat']==$ftingkat;
                       });
                        $sql = "SELECT *,tmakul.NamaMakul, tdosen.Nama from ttest
                                left join tmakul on tmakul.IdMakul = ttest.makul
                                left join tdosen on tdosen.IdDosen = ttest.dosen  where sheets_id='$link'";
                        $query = mysqli_query($connect, $sql);
                        $testQ = mysqli_fetch_array($query);
                        $judul = $testQ['NamaMakul'] . " - " . $testQ['Nama'];
                        }
  
                    ?>

                    <h3>Pencetakan Nilai</h3>
                    <form action="" method="post">
                        <label for="">Pilih Mata Kuliah</label>
                        <select name="makul" id="makul" class="form-control"onchange="this.form.submit()">
                            <option value="">--</option>
                            <?php
                                $sql = mysqli_query($connect,"SELECT ttest.id_test, ttest.sheets_id, ttest.makul, ttest.dosen,
                                tjurusan.NamaJurusan, tmakul.NamaMakul
                                from ttest
                                left join tjurusan on tjurusan.IdJurusan = ttest.id_jurusan
                                left join tmakul on tmakul.IdMakul = ttest.makul");
                                while($row = mysqli_fetch_array($sql))
                                {           (isset($_POST['makul']) && $_POST['makul'] == $data['sheets_id']) ? $selected = 'selected': $selected = "" ;
                                    echo "<option value='$row[sheets_id]' $selected>$row[NamaJurusan] - $row[NamaMakul]</option>";
                                }
                                
                            ?>
                        </select>
                    </form>
                    <?php if(!isset($data) && $data==null)
                    {
                        echo $exc;
                    }
                    else {
                    ?>
                    <div class="w-100 d-flex justify-content-center mt-3 mb-3">
                        
                        <a href="../pdf.php?id=<?php echo $sheetsId ?>&judul=<?php echo $judul ?>" target="__blank" class="btn btn-sm btn-success mr-2">PDF</a>
                        <a href="?pg=nilai&ac=import&id=<?php echo $sheetsId ?>" target="__blank" class="btn btn-sm btn-info">Import ke Database</a>
                    </div>
                        <div class="border p-4 m-auto shadow-lg w-25">
                        <form action="" method="post" id="filter-form">
                        <div class="form-group">
                            <label for="">Pilih Prodi : </label>
                            <input type="hidden" name='sheets' value='<?php echo $link ?>'>
                            <select name="prodi" id="prodi" class="form-control form-control-sm">
                                <?php 
                                    for($i=0; $i<=count($prodi); $i++)
                                    {
                                        echo "<option value='$prodi[$i]'>$prodi[$i]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Tingkat : </label>
                            <select name="tingkat" id="tingkat" class="form-control form-control-sm">
                                <?php 
                                    for($i=0; $i<=count($tingkat); $i++)
                                    {
                                        echo "<option value='$tingkat[$i]'>$tingkat[$i]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name='filter' class='btn btn-sm btn-secondary w-100' value='Filter'>
                        </div>
                    </form>
                    </div>  
                    <h3 class="text-center mt-3"><?php echo $judul ?></h3>
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
                                <?php 
                                $i= 1; 
                                foreach($data as $dataa) { 

                                ?>
                                <tr <?php echo ($dataa['Score'] >56) ? "" : "style='background:rgb(255, 100, 100)'" ;?>>
                                    <td><?= $i++ ?></td>
                                    <td><?php echo (!isset($dataa['NIM'])) ? "" : $dataa['NIM'];?></td>
                                    <td><?php echo (!isset($dataa['Nama Lengkap'])) ? "" : $dataa['Nama Lengkap'];?></td>
                                    <td><?php echo (!isset($dataa['Prodi'])) ? "" : $dataa['Prodi'];?></td>

                                    <td><?php echo (!isset($dataa['Tingkat'])) ? "" : $dataa['Tingkat'];?></td>
                                    <td><?= $dataa['Score']?></td>
                                    <td><?php echo($dataa['Score'] < 56) ?"Tidak Lulus" :"Lulus" ?></td>
                                </tr>    
                                <?php } 
                                ?>
                        </tbody>
                    </table>
                    
                    <table class="table w-25 table-border">
                        <tr>
                            <td>Rata-Rata :</td>
                            <td><?php $sum = 0;

                                foreach ($data as $ent) {
                                    $b = (float)$ent['Score'];
                                    $sum += $b;
                                }
                                $score = array_column($data,'Score'); 
                                $count = count($score);
                                $avg = $sum/$count;
                                echo number_format((float)$avg,2,'.',''); ?></td>
                        </tr>
                        <tr>
                            <td>Nilai Tertinggi</td>
                            <td><?php $scores =array_column($data, 'Score'); echo max($scores);?></td>
                        </tr>
                        <tr>
                            <td>Nilai Terendah</td>
                            <td><?php $scores =array_column($data, 'Score'); echo min($scores);?></td>
                        </tr>
                        <tr>
                            <td>LULUS</td>
                            <td><?php
                                $count = 0;

                                foreach ($data as $item) {
                                    if ($item['Score'] > 56) {
                                        $count++;
                                    }
                                }
                                echo $count;
                            ?></td>
                        </tr>
                        <tr>
                            <td>TIDAK LULUS</td>
                            <td><?php
                                $count = 0;

                                foreach ($data as $item) {
                                    if ($item['Score'] < 56) {
                                        $count++;
                                    }
                                }
                                echo $count;
                            ?></td>
                        </tr>
                    </table>
                    <?php } ?>
                <?php
                break;
                case "makul":
                    if(!isset($_GET['act']))
                    {
                        $sql = "SELECT ttest.id_test, ttest.sheets_id, ttest.makul, ttest.dosen,
                        tjurusan.NamaJurusan, tdosen.Nama, tmakul.NamaMakul
                        from ttest
                        left join tjurusan on tjurusan.IdJurusan = ttest.id_jurusan
                        left join tdosen on tdosen.IdDosen = ttest.dosen
                        left join tmakul on tmakul.IdMakul = ttest.makul";
                        $query = mysqli_query($connect, $sql);

                        ?>
                        <div class="container d-flex flex-column align-items-center">
                            <div class="tambah w-100 mb-3 d-flex justify-content-between"><h4>List Mata Kuliah Test</h4><a href="?pg=makul&act=tambah" class="btn btn-success">Tambah Test</a></div>
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Mata Kuliah</th>
                                        <th>Prodi</th>
                                        <th>Dosen</th>
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
                                        <tr>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['NamaMakul'] ?></td>
                                            <td><?php echo $row['NamaJurusan'] ?></td>
                                            <td><?php echo $row['Nama'] ?></td>
                                            <td><a href="?pg=makul&act=edit&id=<?php echo $row['id_test'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a onclick ="return confirm('Yakin Hapus Data <?php echo $row['makul']?>')" href="?pg=makul&act=hapus&id=<?php echo $row['id_test'] ?>" class="btn btn-sm btn-danger">Hapus</a>
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
                                        <div class="form-group">
                                            <label for="">Jurusan</label>
                                            <select name="jurusan" id="" class="form-control" required>
                                                <?php
                                                    $sql = mysqli_query($connect,"SELECT * from tjurusan");
                                                    while($data = mysqli_fetch_array($sql))
                                                    {
                                                        echo "<option value='$data[IdJurusan]'>$data[NamaJurusan]</option>";
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Mata Kuliah</label>
                                            <input type="text" id="makul" name='makul' class="form-control" onkeyup="showSuggestionMakul(this.value)" required>
                                            <input type="hidden" id="kdMakul" name="KdMakul">
                                            <div id="suggestion-makul"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Dosen</label>
                                            <input type="text" id="search" name='dosen' class="form-control" onkeyup="showSuggestion(this.value)" required>
                                            <input type="hidden" id="kdDosen" name="KdDosen">
                                            <ul id="suggestion-box"></ul>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Link google sheets</label>
                                            <input type="text" name="sheets" class="form-control" id="sheets" required>
                                            <div id="check-data"></div>
                                            <button class="btn btn-sm btn-warning mt-2" id="cek" name="cek">Cek Link</button>
                                        </div>
                                </div>
                                <div class="card-footer">
                                        <input type="submit" name="tambah_test" class="btn btn-info" value="Simpan">
                                    </form>
                                </div>
                            </div>
                        
                        </div>
                           <?php
                        }
                        elseif($_GET['act']=="edit")
                        {
                            $id = $_GET['id'];
                            $sql = "SELECT * from ttest where id_test = '$id'";
                            $query = mysqli_query($connect, $sql);
                            $row = mysqli_fetch_array($query);
                           ?>
                           <div class="container d-flex justify-content-center">
                            <div class="card" style="width:30rem">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>Tambah Test</h4>
                                    <a href="?pg=makul" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="card-body">
                                    <form action="action.php" method="post" id="form-tambah">
                                        <input type="hidden" name="id_test" value="<?php echo $row['id_test'] ?>">
                                        <div class="form-group">
                                            <label for="">Jurusan</label>
                                            <select name="jurusan" id="" class="form-control" required>
                                                <?php
                                                    $sql = mysqli_query($connect,"SELECT * from tjurusan");
                                                    while($data = mysqli_fetch_array($sql))
                                                    {
                                                        ($row['id_jurusan']==$data['IdJurusan']) ? $selected = 'selected' : $selected = '' ;
                                                        echo "<option value='$data[IdJurusan]' $selected>$data[NamaJurusan]</option>";
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Mata Kuliah</label>
                                            <input type="text" id="makul" name='makul' class="form-control" onkeyup="showSuggestionMakul(this.value)" value="<?php echo $row['makul']?>" required>
                                            <input type="hidden" id="kdMakul" name="KdMakul">
                                            <div id="suggestion-makul"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Dosen</label>
                                            <input type="text" id="search" name='dosen' class="form-control" onkeyup="showSuggestion(this.value)" value="<?php echo $row['dosen']?>" required>
                                            <input type="hidden" id="kdDosen" name="KdDosen">
                                            <ul id="suggestion-box"></ul>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Link google sheets</label>
                                            <input type="text" name="sheets" class="form-control" id="sheets" value="<?php echo $row['sheets_id']?>" required>
                                            <div id="check-data"></div>
                                            <button class="btn btn-sm btn-warning mt-2" id="cek" name="cek">Cek Link</button>
                                        </div>
                                </div>
                                <div class="card-footer text-center">
                                        <input type="submit" name="update_test" class="btn btn-info" value="Update">
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
                    echo ($query) ? "<script>alert('Berhasil Hapus Data'); window.location = 'dashboard.php?pg=makul';</script>" 
                                  : "<script>alert('Gagal Hapus Data'); window.location = 'dashboard.php?pg=makul';</script>";
                    }
                    
                    }
                break;
                
            }
        }
            ?>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    
  

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../assets/script.js"></script>
<script>
</script>
<!-- Menu Toggle Script -->

</body>
</html>