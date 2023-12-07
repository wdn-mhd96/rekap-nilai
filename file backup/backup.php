<?php 
    if (isset($_POST['makul'])) {
                            $link = filter_var($_POST['makul'], FILTER_SANITIZE_STRING);
                        $result = get_json($link);
                        $data = $result['data'];
                        $prodi = $result['prodi'];
                        $tingkat = $result['tingkat'];
                        $sheetsId = $result['sheetsId'];
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
                            <a href="?pg=nilai&ac=import&id=<?php echo $link ?>" class="btn btn-sm btn-info">Import ke Database</a>
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
                                ($item['Score'] > 56) ? $lulus++ : $tidakLulus++ ;
                            }   
                        ?>
                        <table class="table w-25 table-border">
                            <tr>
                                <td>Rata-Rata :</td>
                                <td><?php echo $avgg ?></td>
                            </tr>
                            <tr>
                                <td>Nilai Tertinggi</td>
                                <td><?php echo $max?></td>
                            </tr>
                            <tr>
                                <td>Nilai Terendah</td>
                                <td><?php echo $min?></td>
                            </tr>
                            <tr>
                                <td>LULUS</td>
                                <td><?php echo $lulus; ?></td>
                            </tr>
                            <tr>
                                <td>TIDAK LULUS</td>
                                <td><?php echo $tidakLulus; ?></td>
                            </tr>
                        </table>

                        <?php }
                    }
                    elseif($_GET['ac']=="import")
                    {
                        $link = filter_var($_GET['id']);
                        $result = get_json($link);
                        $data = $result['data'];
                        var_dump($data);
                        ?>
                            
                        <?php
                    }