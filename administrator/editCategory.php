<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){
        if(isset($_POST['namaKategori']) && isset($_POST['id']) && isset($_POST['photoStatus'])){

            $target_dir = dirname(__FILE__).'/img/kategori_menu/';
            $namaKategori = trim(strip_tags(ucwords(strtolower($_POST['namaKategori']))));

            if($namaKategori!=''){
                $stmt = $db->prepare('UPDATE kategori_tb SET nama_kategori =:namaKategori WHERE id =:id');
                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                $stmt->bindParam(':namaKategori', $namaKategori, PDO::PARAM_STR, 100);
                
                if($stmt->execute()){
                    if(is_uploaded_file($_FILES['gambarKategori']['tmp_name'])){
                        $stmt = $db->prepare('SELECT nama_foto FROM kategori_tb WHERE id = :id');
                        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                        $stmt->execute();
                        $nama_gambar = $stmt->fetch(PDO::FETCH_ASSOC);

                        if($nama_gambar['nama_foto']!='non.png'){
                            $fullTarget = $target_dir.$nama_gambar['nama_foto'];
                            unlink($fullTarget);
                        }

                        $filename = $_POST['id'].'.'.strtolower(pathinfo($_FILES['gambarKategori']['name'], PATHINFO_EXTENSION));
                        $stmt = $db->prepare('UPDATE kategori_tb SET nama_foto = :nama_foto WHERE id = :id');
                        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                        $stmt->bindParam(':nama_foto', $filename, PDO::PARAM_STR, 255);
        
                        if($stmt->execute()){
                            $target_file = $target_dir.$filename;
                            if(move_uploaded_file($_FILES['gambarKategori']['tmp_name'], $target_file)){
                        
                                header('Location: addEditCategory.php?id='.$_POST['id'].'&sucessfull=1');
                            }
                        }
                    }
                    else{
                        if($_POST['photoStatus']==1){
                            header('Location: addEditCategory.php?id='.$_POST['id'].'&sucessfull=1');
                        }
                        else if($_POST['photoStatus']==0){
                            $stmt = $db->prepare('SELECT nama_foto FROM kategori_tb WHERE id = :id');
                            $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                            $stmt->execute();
                            $nama_gambar = $stmt->fetch(PDO::FETCH_ASSOC);

                            $fullTarget = $target_dir.$nama_gambar['nama_foto'];
                            unlink($fullTarget);

                            $stmt = $db->prepare('UPDATE kategori_tb SET nama_foto = "non.png" WHERE id = :id');
                            $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);    
                            $stmt->execute();

                            header('Location: addEditCategory.php?id='.$_POST['id'].'&sucessfull=1');
                        }
                    }
                }
            }
            else{
                header('Location: addEditCategory.php?id='.$_POST['id'].'&sucessfull=0');
            } 
        }
    }
?>