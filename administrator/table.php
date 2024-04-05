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
        <script src="_library/js/table.js"></script>
        <title>Table | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include("_framework/header.php");
            if(isset($_SESSION['responseDelete'])){
                
                if($_SESSION['responseDelete']==1){
                    $colorDiv = 'alert-success';
                    $textDiv = 'Table berhasil dihapus.';    
                }
                else if($_SESSION['responseDelete']==0){
                    $colorDiv = 'alert-danger';  
                    $textDiv = 'Terjadi kesalahan. Gagal menghapus.'; 
                }
                else if($_SESSION['responseDelete']==2){
                    $colorDiv = 'alert-danger';  
                    $textDiv = 'Terjadi kesalahan. Data tidak ditemukan.'; 
                }
                
                else if($_SESSION['responseDelete']==3){
                    $colorDiv = 'alert-danger';  
                    $textDiv = 'Terjadi kesalahan. Tidak dapat menghapus meja yang sedang dipesan.'; 
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
                        <h5 class="modal-title">Detail Table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3 id="namaTableModal" class="text-center text-break"></h3>
                        <hr class="w-50" style="margin: auto;"><br>
                        <p style="font-weight: bold;" class="m-0">Status:</p>
                        <p id="statusTableModal" class="text-break"></p>

                        <p style="font-weight: bold;" class="m-0">Kapasitas:</p>
                        <p id="kapasitasTableModal" class="text-break"></p>

                        <p style="font-weight: bold;" class="m-0">Harga:</p>
                        <p id="hargaTableModal" class="text-break"></p>
                        
                        <p style="font-weight: bold;" class="m-0">Posisi:</p>
                        <p id="posisiTableModal" class="text-break text-wrap"></p>

                        <p style="font-weight: bold;" class="m-0">Deskripsi:</p>
                        <p id="deskripsiTableModal"></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <h4 class="text-break" id="hargaMakananModal"></h4>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="text-center">Table</h1>
        <div class="mt-3 p-2">
            <div>
                <a class="icon-plus-squared btn btn-primary" href="addEditTable.php" style="text-decoration: none; color:white;">Tambah</a>
            </div>

            <div class="mt-4">
                <?php 
                    $stmt = $db->prepare('SELECT * FROM reserve_table_tb');
                    $stmt->execute();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    for($i=0; $i<count($output); $i++){
                        echo'<div class="py-2">
                                <div class="container-fluid m-0 border-bottom row p-2">
                                    <div id="kapasitasTable-'.$output[$i]['id'].'" class="col-12 col-sm-1 d-flex align-items-center text-break border-start">'.$output[$i]['kapasitas'].'</div>
                                    <div class="col-12 col-sm-9 border-start">
                                        <button id="btnDescTable-'.$output[$i]['id'].'"class="btn w-100 h-100 text-start btnDescTable px-0"><div id="namaTable-'.$output[$i]['id'].'" class="text-truncate m-0">'.$output[$i]['nama_meja'].'</div></button>
                                    </div>
                                    <div id="statusTable-'.$output[$i]['id'].'" hidden>'.$output[$i]['status'].'</div>
                                    <div id="hargaTable-'.$output[$i]['id'].'" hidden>Rp. '.number_format($output[$i]['harga'], 0, '.', ',').'</div>
                                    <span id="descTable-'.$output[$i]['id'].'" disable hidden>'.$output[$i]['deskripsi'].'</span>
                                    <span id="posisiTable-'.$output[$i]['id'].'" hidden>'.$output[$i]['posisi'].'</span>
                                    <div class="col-12 col-sm-2 d-flex justify-content-center border-start">
                                        <div class="d-flex justify-content-end h-100 align-items-center">
                                            <a class="icon-pencil p-2" href="addEditTable.php?id='.$output[$i]['id'].'" style="text-decoration:none; color:black"></a>
                                            <a class="icon-trash p-2" href="deleteTable.php?id='.$output[$i]['id'].'" style="text-decoration:none; color:black"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>