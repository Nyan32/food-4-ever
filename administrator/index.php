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
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/index.js"></script>

        <link href="_library/css/index.css" rel="stylesheet"/>
        <title>Menu | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include("_framework/header.php");
            if(isset($_SESSION['responseDelete'])){
                
                if($_SESSION['responseDelete']==1){
                    $colorDiv = 'alert-success';
                    $textDiv = 'Menu berhasil dihapus.';    
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
        <div id="viewModal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center p-2">
                            <img class="img-fluid" id="gambarMakananModal" src=""/>
                        </div>
                        <h3 id="namaMakananModal" class="text-center text-break"></h3>
                        <hr class="w-50" style="margin: auto;"><br>
                        <p id="deskripsiMakananModal" style="text-align: justify"></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <h4 class="text-break" id="hargaMakananModal"></h4>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="text-center">Menu</h1>
        <div class="mt-3 p-2">
            <div>
                <a class="icon-plus-squared btn btn-primary" href="addEdit.php" style="text-decoration: none; color:white;">Tambah</a>
            </div>

            <div class="mt-4">
                <?php 
                    $stmt1 = $db->prepare('SELECT * FROM kategori_tb');
                    $stmt1->execute();
                    $output1 = $stmt1->fetchAll(PDO::FETCH_NUM);

                    for($i=0; $i<count($output1); $i++){
                        echo'<div class="py-2">
                                <button id="btnMenu-'.$output1[$i][0].'" class="btn-category btn d-flex align-items-center justify-content-between btn-light w-100">
                                    <span style="font-size: 7mm;">'.$output1[$i][1].'</span> 
                                    <span id="iconArrow-'.$output1[$i][0].'" class="icon-up-open"></span>   
                                </button>
                                <div data-isActive="true" id="menu-list-'.$output1[$i][0].'">';
                        $stmt2 = $db->prepare('SELECT * FROM menu_tb WHERE kategori_id = :id');
                        $stmt2->bindParam(':id', $output1[$i][0], PDO::PARAM_INT, 255);
                        $stmt2->execute();
                        $output2 = $stmt2->fetchAll(PDO::FETCH_NUM);
                        for($j=0; $j<count($output2); $j++){
                            echo '
                                <div class="container-fluid m-0 border-bottom row p-2">
                                    <div class="col-12 col-sm-2 border-start">
                                        <img id="imgMenu-'.$output2[$j][0].'" class="img-fluid" src="img/menu/'.$output2[$j][4].'?'.time().'"/>    
                                    </div>
                                    <div class="col-12 col-sm-8 border-start">
                                        <button id="btnDescMenu-'.$output2[$j][0].'"class="btn w-100 h-100 text-start btnDescMenu px-0"><div id="namaMenu-'.$output2[$j][0].'" class="text-truncate m-0">'.$output2[$j][1].'</div></button>
                                    </div>
                                    <span id="descMenu-'.$output2[$j][0].'" disable hidden>'.$output2[$j][3].'</span>
                                    <span id="hargaMenu-'.$output2[$j][0].'" hidden>'.sprintf('Rp %d', $output2[$j][2]).'</span>
                                    <div class="col-12 d-flex justify-content-center align-items-center col-sm-2 border-start">
                                        <div class="d-flex justify-content-end h-100 align-items-center">
                                            <a class="icon-pencil p-2" href="addEdit.php?id='.$output2[$j][0].'" style="text-decoration:none; color:black"></a>
                                            <a class="icon-trash p-2" href="delete.php?id='.$output2[$j][0].'" style="text-decoration:none; color:black"></a>
                                        </div>
                                    </div>
                                </div>';
                        }
                        echo'</div></div>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>