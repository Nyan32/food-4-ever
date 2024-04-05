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
        $stmt = $db->prepare('SELECT * FROM kategori_tb WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
        $stmt->execute();

        $output = $stmt->fetch(PDO::FETCH_ASSOC);
    }   
?>

<!DOCTYPE html>

<html translate="no">
    <head>
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/addEditCategory.js"></script>
        <title><?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Kategori | Database Food4Ever';
                    }
                    else{
                        echo 'Tambahkan Kategori Baru | Database Food4Ever';    
                    }
                ?></title>
    </head>

    <body>
        <?php 
            include('_framework/header.php');

            if(isset($_GET['sucessfull']) && isset($_GET['id'])){
                if($_GET['sucessfull']==1){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Kategori berhasil diubah.
                        </div>';
                }
                else if($_GET['sucessfull']==0){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Kategori gagal diubah.
                        </div>';    
                }
            }

            else if(isset($_GET['sucessfull']) && !isset($_GET['id'])){
                if($_GET['sucessfull']==1){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Kategori berhasil ditambahkan.
                        </div>';
                }
                else if($_GET['sucessfull']==0){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Kategori gagal ditambahkan.
                        </div>';    
                }
            }
        ?>
        <div class="mt-5 p-2 m-auto" style="max-width: 600px">
            <h4 class="text-center">
                <?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Kategori';
                    }
                    else{
                        echo 'Tambahkan Kategori Baru';    
                    }
                ?>     
            </h4>
            <hr>
            <form action="<?php
                if(isset($_GET['id'])){
                    echo 'editCategory.php';
                }
                else{
                    echo 'addCategory.php';    
                }
            ?>" method="POST" enctype="multipart/form-data">
                <?php
                    if(isset($_GET['id'])){
                        echo '<input type="hidden" name="id" value="'.$_GET['id'].'"/>';
                    }
                ?>
                <div class="py-2">
                    <label class="form-label" for="namaKategori">Nama Kategori*:</label>
                    <input id="namaKategori" name="namaKategori" value="<?php 
                        if(isset($_GET['id'])){
                            echo $output['nama_kategori'];
                        }
                        else{
                            echo '';
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>

                <div class="py-2">
                    <label class="form-label" for="gambarKategori">Masukkan Gambar:</label>
                    <input name="gambarKategori" id="gambarKategori" type="file" hidden/>
                    
                    <div class="d-flex align-items-center">
                        <button type="button" id="deleteGambarBtn" class="btn btn-primary h-100">Hapus</button>
                        <button type="button" id="gambarKategoriBtn" class="btn btn-primary h-100 ms-2">Pilih</button>
                        <input id="gambarKategoriName" value=<?php
                            if(isset($_GET['id'])){   
                                echo'"'.$output['nama_foto'].'"';
                            }
                            else{
                                echo'""';
                            }
                        ?> type="text" class="w-25 p-2 ms-2" disabled/>  
                    </div>
                    <div class="py-2">
                        <?php
                            if(isset($_GET['id'])){
                                echo '<input id="photoStatus" type="hidden" name="photoStatus" data-image="'.$output['nama_foto'].'" value="1"/>';
                            }
                        ?>
                        <div class="bg-secondary d-flex justify-content-center">
                            <img id="imageReview" class="p-2" src=<?php
                                if(isset($_GET['id'])){
                                    echo '"img/kategori_menu/'.$output['nama_foto'].'?dummy='.filemtime(dirname(__FILE__).'/img/kategori_menu/'.$output['nama_foto']).'"';
                                }
                                else{
                                    echo'"img/kategori_menu/non.png"';
                                }
                            ?>style="width: 70%;"/>    
                            
                        </div>
                    </div>
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