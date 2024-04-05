<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){  
        if($_FILES['gambarFoto']['name']!=''){
            $target_dir =  dirname(__FILE__).'/img/restoran/';

            $stmt = $db->prepare('INSERT INTO gallery_foto_restaurant_tb VALUES(NULL, "tmp")');

            if($stmt->execute()){
                $id = $db->lastInsertId();
                if(is_uploaded_file($_FILES['gambarFoto']['tmp_name'])){
                    $filename = $id.'.'.strtolower(pathinfo($_FILES['gambarFoto']['name'], PATHINFO_EXTENSION));
                    $stmt = $db->prepare('UPDATE gallery_foto_restaurant_tb SET nama_foto = :nama_foto WHERE id = :id');
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                    $stmt->bindParam(':nama_foto', $filename, PDO::PARAM_STR, 255);
    
                    if($stmt->execute()){
                        $target_file = $target_dir.$filename;
                        if(move_uploaded_file($_FILES['gambarFoto']['tmp_name'], $target_file)){
                            header('Location: addPhoto.php?sucessfull=1');
                        }
                    }
                }
            }
        }
    }
    else{
        header('Location: addPhoto.php?sucessfull=0');
    }
?>