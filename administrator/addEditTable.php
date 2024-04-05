<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT COUNT(*) AS count_acc FROM admin_tb WHERE SHA2(email ,256) = :email');
    $stmt->bindParam(':email', $_SESSION['adminID']);
    $stmt->execute();
    
    $personal_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if($personal_info['count_acc']==0){
        header('Location:login.php');
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $db->prepare('SELECT * FROM reserve_table_tb WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
        $stmt->execute();

        $output = $stmt->fetch(PDO::FETCH_ASSOC);
    }   
?>

<!DOCTYPE html>

<html translate="no">
    <head>
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/addEditTable.js"></script>
        <title><?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Table | Database Food4Ever';
                    }
                    else{
                        echo 'Tambahkan Table Baru | Database Food4Ever';    
                    }
                ?></title>
    </head>

    <body>
        <?php 
            include('_framework/header.php');

            if(isset($_GET['sucessfull']) && isset($_GET['id'])){
                if($_GET['sucessfull']==1){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Table berhasil diubah.
                        </div>';
                }
                else if($_GET['sucessfull']==0){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Table gagal diubah.
                        </div>';    
                }
            }

            else if(isset($_GET['sucessfull']) && !isset($_GET['id'])){
                if($_GET['sucessfull']==1){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Table berhasil ditambahkan.
                        </div>';
                }
                else if($_GET['sucessfull']==0){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Table gagal ditambahkan.
                        </div>';    
                }
            }
        ?>
        <div class="mt-5 p-2 m-auto" style="max-width: 600px">
            <h4 class="text-center">
                <?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Table';
                    }
                    else{
                        echo 'Tambahkan Table Baru';    
                    }
                ?>     
            </h4>
            <hr>
            <form action="<?php
                if(isset($_GET['id'])){
                    echo 'editTable.php';
                }
                else{
                    echo 'addTable.php';    
                }
            ?>" method="POST" enctype="multipart/form-data">
                <?php
                    if(isset($_GET['id'])){
                        echo '<input type="hidden" name="id" value="'.$_GET['id'].'"/>';
                    }
                ?>
                <div class="py-2">
                    <label class="form-label" for="namaTable">Nama Meja*:</label>
                    <input id="namaTable" name="namaTable" value="<?php 
                        if(isset($_GET['id'])){
                            echo $output['nama_meja'];
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>

                <div class="py-2">
                    <label class="form-label" for="kapasitasTable">Kapasitas Meja*:</label>
                    <input id="kapasitasTable" name="kapasitasTable" value="<?php
                        if(isset($_GET['id'])){
                            echo $output['kapasitas'];
                        }
                    ?>" type="text" class="form-control" required/> 
                </div>

                <div class="py-2">
                    <label class="form-label" for="hargaTable">Harga Meja*:</label>
                    <input id="hargaTable" name="hargaTable" value="<?php
                        if(isset($_GET['id'])){
                            echo $output['harga'];
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>

                <div class="py-2">
                    <label class="form-label" for="posisiTable">Posisi*:</label>
                    <input id="posisiTable" name="posisiTable" value="<?php 
                        if(isset($_GET['id'])){
                            echo $output['posisi'];
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>

                <div class="py-2">
                    <label class="form-label" for="deskripsiTable">Deskripsi Meja:</label>
                    <textarea id="deskripsiTable" name="deskripsiTable" class="form-control" style="resize: none;height:3cm"><?php
                        if(isset($_GET['id'])){
                            echo $output['deskripsi'];
                        }
                    ?></textarea>    
                </div>

                <div class="py-2"> 
                    <label class="form-label" for="statusTable">Status Meja:</label>
                    <select class="form-select" id="statusTable" name="statusTable">
                        <option value="tersedia" <?php 
                        if(isset($_GET['id'])){
                            if($output['status']=='tersedia'){
                                echo 'selected';
                            }
                        }
                        ?>>Tersedia</option>
                        <option value="tidak tersedia" <?php 
                        if(isset($_GET['id'])){
                            if($output['status']=='tidak tersedia'){
                                echo 'selected';
                            }
                        }
                        ?>>Tidak Tersedia</option>
                    </select>    
                </div>

                <br>
                <p class="form-text">* wajib diisi</p>
                <p class="text-center">
                    <button type="submit" name="submitBtn" class="btn btn-primary">Submit</button>
                </p>
            </form>
        </div>
    </body>
</html>