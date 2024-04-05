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
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $stmt = $db->prepare('SELECT COUNT(*) AS jumlah, status FROM reserve_table_tb WHERE id=:id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
            if($stmt->execute()){
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if($data['jumlah']<1){
                    $_SESSION['responseDelete']=2;
                    header('Location: table.php');
                }
                else{
                    if($data['status']=='tersedia'){
                        $stmt = $db->prepare('DELETE FROM reserve_table_tb WHERE id = :id');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                        if($stmt->execute()){
                            $rowCount = $stmt->rowCount();
                            if($rowCount>0){
                                $stmt = $db->prepare('UPDATE menu_tb SET kategori_id=0 WHERE kategori_id=:id');
                                $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                                $stmt->execute();
                                $result = 1;
                            }
                            else{
                                $result = 0;    
                            }
                    
                            
                            $_SESSION['responseDelete'] = $result;
                            header('Location: table.php');
                        }
                    }
                    else{
                        $_SESSION['responseDelete']=3;
                        header('Location: table.php');
                    }
                }
            }
        }
    } 
    
?>