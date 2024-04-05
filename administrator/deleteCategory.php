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
    else{
        $target_dir =  dirname(__FILE__).'/img/kategori_menu/';
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $stmt = $db->prepare('SELECT COUNT(*) AS jumlah, nama_foto FROM kategori_tb WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
            if($stmt->execute()){
                $nama_gambar = $stmt->fetch(PDO::FETCH_ASSOC);
                if($nama_gambar['jumlah']<1){
                    $_SESSION['responseDelete']=2;
                    header('Location: category.php');
                }
                else{
                    $stmt = $db->prepare('DELETE FROM kategori_tb WHERE id = :id');
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                    if($stmt->execute()){
                        $rowCount = $stmt->rowCount();
                        if($rowCount>0){
                            $stmt = $db->prepare('UPDATE menu_tb SET kategori_id=0 WHERE kategori_id=:id');
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                            $stmt->execute();
                            if($nama_gambar['nama_foto']!='non.png'){
                                $fullTarget = $target_dir.$nama_gambar['nama_foto'];
                                unlink($fullTarget);
                            }
                            $result = 1;
                        }
                        else{
                            $result = 0;    
                        }
                
                        
                        $_SESSION['responseDelete'] = $result;
                        header('Location: category.php');
                    }
                }
            }
        }
    } 
    
?>