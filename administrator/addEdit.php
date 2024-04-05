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
        $stmt = $db->prepare('SELECT * FROM menu_tb WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
        $stmt->execute();

        $output = $stmt->fetch(PDO::FETCH_ASSOC);
    }   
?>

<!DOCTYPE html>

<html translate="no">
    <head>
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/addEdit.js"></script>
        <title><?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Menu | Database Food4Ever';
                    }
                    else{
                        echo 'Tambahkan Menu Baru | Database Food4Ever';    
                    }
                ?></title>
    </head>

    <body>
        <?php 
            include('_framework/header.php');

            if(isset($_SESSION['sucessfull']) && isset($_GET['id'])){
                if($_SESSION['sucessfull']==TRUE){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Menu berhasil diubah.
                        </div>';
                }
                else if($_SESSION['sucessfull']==FALSE){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Menu gagal diubah.
                        </div>';    
                }
            }
            else if(isset($_SESSION['sucessfull']) && !isset($_GET['id'])){
                if($_SESSION['sucessfull']==TRUE){
                    echo '<div class="w-100 p-2 alert alert-success">
                            Menu berhasil ditambahkan.
                        </div>';
                }
                else if($_SESSION['sucessfull']==FALSE){
                    echo '<div class="w-100 p-2 alert alert-danger">
                            Menu gagal ditambahkan.
                        </div>';    
                }
            }

            unset($_SESSION['sucessfull']);
        ?>
        <div class="mt-5 p-2 m-auto" style="max-width: 600px">
            <h4 class="text-center">
                <?php
                    if(isset($_GET['id'])){
                        echo 'Ubah Menu';
                    }
                    else{
                        echo 'Tambahkan Menu Baru';    
                    }
                ?>     
            </h4>
            <hr>
            <form action=<?php
                if(isset($_GET['id'])){
                    echo '"edit.php"';
                }
                else{
                    echo '"add.php"';    
                }
            ?> method="POST" enctype="multipart/form-data">
                <?php
                    if(isset($_GET['id'])){
                        echo '<input type="hidden" name="id" value="'.$_GET['id'].'"/>';
                    }
                ?>
                <div class="py-2">
                    <label class="form-label" for="namaMakanan">Nama Menu*:</label>
                    <input id="namaMakanan" name="namaMakanan" value="<?php 
                        if(isset($_GET['id'])){
                            echo $output['nama_makanan'];
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>
                <div class="py-2"> 
                    <label class="form-label" for="kategoriMakanan">Kategori Menu:</label>
                    <select class="form-select" name="kategoriMakanan">
                        <?php
                            if(isset($_GET['id'])){
                                $kategori_id = $output['kategori_id'];
                            }
                            else{
                                $kategori_id = null;
                            }

                            $stmt = $db->prepare('SELECT * FROM kategori_tb');
                            $stmt->execute();
                            $kategoriOutput = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            for($i=0;$i<count($kategoriOutput);$i++){
                                if($output['kategori_id']==$kategoriOutput[$i]['id']){
                                    echo '<option value="'.$kategoriOutput[$i]['id'].'" selected>'.$kategoriOutput[$i]['nama_kategori'].'</option>';
                                }
                                else{
                                    echo '<option value="'.$kategoriOutput[$i]['id'].'">'.$kategoriOutput[$i]['nama_kategori'].'</option>';    
                                }
                            }
                        ?>
                    </select>    
                </div>
                <div class="py-2">
                    <label class="form-label" for="hargaMakanan">Harga Menu*:</label>
                    <input id="hargaMakanan" name="hargaMakanan" value="<?php
                        if(isset($_GET['id'])){
                            echo $output['harga_makanan'];
                        }
                    ?>" type="text" class="form-control" required/>    
                </div>
                <div class="py-2">
                    <label class="form-label" for="deskripsiMakanan">Deskripsi Menu:</label>
                    <textarea name="deskripsiMakanan" class="form-control" style="resize: none;height:3cm"><?php
                        if(isset($_GET['id'])){
                            echo $output['deskripsi_makanan'];
                        }
                    ?> </textarea>    
                </div>
                <div class="py-2">
                    <label class="form-label" for="gambarMakanan">Masukkan Gambar:</label>
                    <input name="gambarMakanan" id="gambarMakanan" type="file" hidden/>
                    
                    <div class="d-flex align-items-center">
                        <button type="button" id="deleteGambarBtn" class="btn btn-primary h-100">Hapus</button>
                        <button type="button" id="gambarMakananBtn" class="btn btn-primary h-100 ms-2">Pilih</button>
                        <input id="gambarMakananName" value=<?php
                            if(isset($_GET['id'])){   
                                echo'"'.$output['gambar_makanan'].'"';
                            }
                            else{
                                echo'""';
                            }
                        ?> type="text" class="w-25 p-2 ms-2" disabled/>  
                    </div>
                    <div class="py-2">
                        <?php
                            if(isset($_GET['id'])){
                                echo '<input id="photoStatus" type="hidden" name="photoStatus" data-image="'.$output['gambar_makanan'].'" value="1"/>';
                            }
                        ?>
                        <div class="bg-secondary d-flex justify-content-center">
                            <img id="imageReview" class="p-2" src=<?php
                                if(isset($_GET['id'])){
                                    echo '"img/menu/'.$output['gambar_makanan'].'?dummy='.filemtime(dirname(__FILE__).'/img/menu/'.$output['gambar_makanan']).'"';
                                }
                                else{
                                    echo'"img/menu/non.png"';
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