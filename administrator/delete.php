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
        $target_dir =  dirname(__FILE__).'/img/menu/';
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $stmt1 = $db->prepare('SELECT gambar_makanan FROM menu_tb WHERE id = :id');
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT, 255);
            if($stmt1->execute()){
                $nama_gambar = $stmt1->fetch(PDO::FETCH_ASSOC);
                if(is_bool($nama_gambar)){
                    $_SESSION['responseDelete']=2;
                    header('Location: index.php');
                }
                else{
                    $stmt = $db->prepare('DELETE FROM menu_tb WHERE id = :id');
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                    if($stmt->execute()){
                        $rowCount = $stmt->rowCount();
                        if($rowCount>0){
                            $result = 1;
                        }
                        else{
                            $result = 0;    
                        }
                
                        if($nama_gambar['gambar_makanan']!='non.png'){
                            $fullTarget = $target_dir.$nama_gambar['gambar_makanan'];
                            unlink($fullTarget);
                        }
                        $_SESSION['responseDelete'] = $result;
                        header('Location: index.php');
                    }
                }
            }
        }
    } 
    
?>