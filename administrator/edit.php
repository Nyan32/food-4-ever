<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){
        if(isset($_POST['namaMakanan']) && isset($_POST['hargaMakanan']) && isset($_POST['deskripsiMakanan']) &&  isset($_POST['kategoriMakanan']) && isset($_POST['id']) && isset($_POST['photoStatus'])){
            $target_dir = dirname(__FILE__).'/img/menu/';
            if($_POST['namaMakanan']!='' && $_POST['hargaMakanan']!=''){
                $stmt = $db->prepare('UPDATE menu_tb SET nama_makanan =:namaMakanan, harga_makanan =:hargaMakanan, deskripsi_makanan =:deskripsiMakanan, kategori_id =:kategoriMakanan WHERE id =:id');
                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                $stmt->bindParam(':namaMakanan', $_POST['namaMakanan'], PDO::PARAM_STR, 100);
                $stmt->bindParam(':hargaMakanan', $_POST['hargaMakanan'], PDO::PARAM_INT, 10);
                $stmt->bindParam(':deskripsiMakanan', $_POST['deskripsiMakanan'], PDO::PARAM_STR, 400);
                $stmt->bindParam(':kategoriMakanan', $_POST['kategoriMakanan'], PDO::PARAM_INT, 255);
                
                if($stmt->execute()){
                    $rowCount = $stmt->rowCount();
                    if($rowCount>0){
                        if(is_uploaded_file($_FILES['gambarMakanan']['tmp_name'])){
                            $stmt = $db->prepare('SELECT gambar_makanan FROM menu_tb WHERE id = :id');
                            $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                            $stmt->execute();
                            $nama_gambar = $stmt->fetch(PDO::FETCH_ASSOC);

                            if($nama_gambar['gambar_makanan']!='non.png'){
                                $fullTarget = $target_dir.$nama_gambar['gambar_makanan'];
                                unlink($fullTarget);
                            }

                            $filename = $_POST['id'].'.'.strtolower(pathinfo($_FILES['gambarMakanan']['name'], PATHINFO_EXTENSION));
                            $stmt = $db->prepare('UPDATE menu_tb SET gambar_makanan = :gambar_makanan WHERE id = :id');
                            $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                            $stmt->bindParam(':gambar_makanan', $filename, PDO::PARAM_STR, 255);
            
                            if($stmt->execute()){
                                $target_file = $target_dir.$filename;
                                if(move_uploaded_file($_FILES['gambarMakanan']['tmp_name'], $target_file)){
                                    $_SESSION['sucessfull'] = TRUE;
                                    header('Location: addEdit.php?id='.$_POST['id']);
                                }
                            }
                        }
                        else{
                            if($_POST['photoStatus']==1){
                                $_SESSION['sucessfull'] = TRUE;
                                header('Location: addEdit.php?id='.$_POST['id']);
                            }
                            else if($_POST['photoStatus']==0){
                                $stmt = $db->prepare('SELECT gambar_makanan FROM menu_tb WHERE id = :id');
                                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                                $stmt->execute();
                                $nama_gambar = $stmt->fetch(PDO::FETCH_ASSOC);

                                $fullTarget = $target_dir.$nama_gambar['gambar_makanan'];
                                unlink($fullTarget);

                                $stmt = $db->prepare('UPDATE menu_tb SET gambar_makanan = "non.png" WHERE id = :id');
                                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);    
                                $stmt->execute();

                                $_SESSION['sucessfull'] = TRUE;
                                header('Location: addEdit.php?id='.$_POST['id']);
                            }
                        }
                    }
                    else{
                        $_SESSION['sucessfull'] = FALSE; 
                        $_SESSION['returnFrom'] = 0;  
                        header('Location: addEdit.php?id='.$_POST['id']);
                    } 
                }
            }
        }
    }
?>