<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){  
        if(isset($_POST['namaKategori']) && !isset($_POST['id'])){
            $target_dir =  dirname(__FILE__).'/img/kategori_menu/';

            $namaKategori = trim(strip_tags(ucwords(strtolower($_POST['namaKategori']))));

            if($namaKategori!=''){
                $stmt = $db->prepare('INSERT INTO kategori_tb VALUES(NULL, :namaKategori, DEFAULT(nama_foto))');
                $stmt->bindParam(':namaKategori', $namaKategori, PDO::PARAM_STR, 100);

                if($stmt->execute()){
                    $id = $db->lastInsertId();
                    if(is_uploaded_file($_FILES['gambarKategori']['tmp_name'])){
                        $filename = $id.'.'.strtolower(pathinfo($_FILES['gambarKategori']['name'], PATHINFO_EXTENSION));
                        $stmt = $db->prepare('UPDATE kategori_tb SET nama_foto = :nama_foto WHERE id = :id');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                        $stmt->bindParam(':nama_foto', $filename, PDO::PARAM_STR, 255);
        
                        if($stmt->execute()){
                            $target_file = $target_dir.$filename;
                            if(move_uploaded_file($_FILES['gambarKategori']['tmp_name'], $target_file)){
                                header('Location: addEditCategory.php?sucessfull=1');
                            }
                        }
                    }
                    else{
                        header('Location: addEditCategory.php?sucessfull=1');
                    }
                }
            }
            else{
                header('Location: addEditCategory.php?sucessfull=0');
            }
        }
    }
?>