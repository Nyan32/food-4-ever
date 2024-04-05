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
?>

<!DOCTYPE html>

<html translate="no">
    <head>
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/addPhoto.js"></script>
        <title>Tambah Foto | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include('_framework/header.php');
            if(isset($_GET['sucessfull'])){
                if($_GET['sucessfull']==1){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Foto berhasil ditambahkan.
                        </div>';
                }
                else if($_GET['sucessfull']==0){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Harap memasukkan foto.
                        </div>';
                }
            }
        ?>
        <div class="mt-5 p-2 m-auto" style="max-width: 600px">
            <h4 class="text-center">Tambahkan Foto</h4>
            <hr>
            <form action="addPhotoProcess.php" method="POST" enctype="multipart/form-data">
                <div class="py-2">
                    <label class="form-label" for="gambarFoto">Masukkan Gambar*:</label>
                    <input name="gambarFoto" id="gambarFoto" type="file" hidden/>
                    
                    <div class="d-flex align-items-center">
                        <button type="button" id="deleteGambarBtn" class="btn btn-primary h-100">Hapus</button>
                        <button type="button" id="gambarFotoBtn" class="btn btn-primary h-100 ms-2">Pilih</button>
                        <input id="gambarFotoName" type="text" class="w-25 p-2 ms-2" disabled/>  
                    </div>
                    <div class="py-2">
                        <div class="bg-secondary d-flex justify-content-center">
                            <img id="imageReview" class="p-2" src="img/kategori_menu/non.png" style="width: 70%;"/>    
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