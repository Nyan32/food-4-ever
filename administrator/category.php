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

<html class="notranslate" translate="no">
    <head>
        <?php include("_library/lib-include.php")?>
        <title>Kategori | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include("_framework/header.php");
            if(isset($_SESSION['responseDelete'])){
                
                if($_SESSION['responseDelete']==1){
                    $colorDiv = 'alert-success';
                    $textDiv = 'Kategori berhasil dihapus.';    
                }
                else if($_SESSION['responseDelete']==0){
                    $colorDiv = 'alert-danger';  
                    $textDiv = 'Terjadi kesalahan. Gagal menghapus.'; 
                }
                else if($_SESSION['responseDelete']==2){
                    $colorDiv = 'alert-danger';  
                    $textDiv = 'Terjadi kesalahan. Data tidak ditemukan.'; 
                }

                unset($_SESSION['responseDelete']);

                echo '  <div id="notifDelete" class="w-100 p-2 alert '.$colorDiv.' d-flex align-items-center justify-content-between">
                            <span>'.$textDiv.'</span>
                            <button type="button" id="btnCloseNotif" class="btn btn-close"></button>
                            <script>
        $("#btnCloseNotif").on("click", function(){
        $("#notifDelete").remove();
        });
                            </script>
                        </div>';
            }
        ?>
        <h1 class="text-center">Kategori</h1>
        <div class="mt-3 p-2">
            <div>
                <a class="icon-plus-squared btn btn-primary" href="addEditCategory.php" style="text-decoration: none; color:white;">Tambah</a>
            </div>

            <div class="mt-4">
                <?php 
                    echo'<div class="py-2">';
                    $stmt = $db->prepare('SELECT * FROM kategori_tb');
                    $stmt->execute();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    for($j=0; $j<count($output); $j++){
                        if($output[$j]['id']!=0){
                            echo '
                            <div class="container-fluid m-0 border-bottom row p-2">
                                <div class="col-12 col-sm-2 border-start">
                                    <img id="imgMenu-'.$output[$j]['id'].'" class="img-fluid" src="img/kategori_menu/'.$output[$j]['nama_foto'].'?'.time().'" style="object-fit:cover"/>    
                                </div>

                                <div class="col-12 col-sm-8 border-start d-flex align-items-center">'.$output[$j]['nama_kategori'].'</div>
                                
                                <div class="col-12 col-sm-2 d-flex justify-content-center align-items-center border-start">
                                    <div class="d-flex justify-content-end h-100 align-items-center">
                                        <a class="icon-pencil p-2" href="addEditCategory.php?id='.$output[$j]['id'].'" style="text-decoration:none; color:black"></a>
                                        <a class="icon-trash p-2" href="deleteCategory.php?id='.$output[$j]['id'].'" style="text-decoration:none; color:black"></a>
                                    </div>
                                </div>
                            </div>';
                        }
                        if($output[$j]['id']==0){
                            echo '
                            <div class="container-fluid m-0 border-bottom row p-2">
                                <div class="col-12 col-sm-2 border-start">
                                    <img id="imgMenu-'.$output[$j]['id'].'" class="img-fluid" src="img/kategori_menu/'.$output[$j]['nama_foto'].'?'.time().'" style="object-fit:cover"/>    
                                </div>

                                <div class="col-12 col-sm-8 border-start d-flex align-items-center">'.$output[$j]['nama_kategori'].'</div>
                                
                                <div class="col-12 col-sm-2 border-start">
                                    
                                </div>
                            </div>';
                        }
                    }
                    echo'</div>';
                ?>
            </div>
        </div>
    </body>
</html>