<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){  
        if(isset($_POST['namaMakanan']) && isset($_POST['hargaMakanan']) && isset($_POST['deskripsiMakanan']) &&  isset($_POST['kategoriMakanan']) && isset($_POST['submitBtn']) && !isset($_POST['id'])){
            $target_dir =  dirname(__FILE__).'/img/menu/';
            $namaMenu = strip_tags(trim(ucwords(strtolower( $_POST['namaMakanan']))));
            $hargaMenu = strip_tags(trim($_POST['hargaMakanan']));
            $deskripsiMakanan = strip_tags(trim($_POST['deskripsiMakanan']));

            if($namaMenu!='' && $hargaMenu!=''){
                $stmt = $db->prepare('INSERT INTO menu_tb VALUES(NULL, :namaMakanan, :hargaMakanan, :deskripsiMakanan, DEFAULT(gambar_makanan), :kategoriMakanan)');
                $stmt->bindParam(':namaMakanan', $namaMenu, PDO::PARAM_STR, 100);
                $stmt->bindParam(':hargaMakanan', $hargaMenu, PDO::PARAM_INT, 10);
                $stmt->bindParam(':deskripsiMakanan', $deskripsiMakanan, PDO::PARAM_STR, 400);
                $stmt->bindParam(':kategoriMakanan', $_POST['kategoriMakanan'], PDO::PARAM_INT, 255);

                if($stmt->execute()){
                    $id = $db->lastInsertId();
                    if(is_uploaded_file($_FILES['gambarMakanan']['tmp_name'])){
                        $filename = $id.'.'.strtolower(pathinfo($_FILES['gambarMakanan']['name'], PATHINFO_EXTENSION));
                        $stmt = $db->prepare('UPDATE menu_tb SET gambar_makanan = :gambar_makanan WHERE id = :id');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                        $stmt->bindParam(':gambar_makanan', $filename, PDO::PARAM_STR, 255);
        
                        if($stmt->execute()){
                            $target_file = $target_dir.$filename;
                            if(move_uploaded_file($_FILES['gambarMakanan']['tmp_name'], $target_file)){
                                $_SESSION['sucessfull'] = TRUE;
                                header('Location: addEdit.php');
                            }
                        }
                    }
                    else{
                        $_SESSION['sucessfull'] = TRUE;
                        header('Location: addEdit.php');
                    }
                }
            }
        }
    }
?>