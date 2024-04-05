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
        <title>Riwayat Pemesanan | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include("_framework/header.php");
        ?>
        <h1 class="text-center">Riwayat Pemesanan</h1>
        <div class="mt-3 p-2">
            <div class="mt-4">
                <?php 
                    echo'<div class="py-2">';
                    $stmt = $db->prepare('SELECT * FROM reserve_history_tb a JOIN account_tb b ON a.acc_id=b.id');
                    $stmt->execute();
                    $purHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(count($purHistory)>0){
                        for($i=0; $i<count($purHistory); $i++){
                            echo'   
                                <div class="d-flex py-2 flex-wrap align-items-stretch w-100 border-bottom">
                                    <div class="d-flex flex-column p-2 col-12 col-sm-9">
                                        <div class="text-wrap text-break w-100" style="text-decoration:underline; font-weight:bold">'.$purHistory[$i]['email'].'</div>
                                        <div class="text-wrap text-break w-100">Tanggal Dipesan: '.$purHistory[$i]['tanggal_dipesan'].'</div>
                                        <div class="text-truncate w-100">Tanggal Pemesanan: '.$purHistory[$i]['tanggal'].'</div>
                                        <div class="text-truncate w-100 d-inline-block">Receipt: '.$purHistory[$i]['receipt_code'].'</div>
                                    </div>
                                    <a class="col-12 col-sm-3 d-flex justify-content-center align-items-center" href="receipt/tempat/'.$purHistory[$i]['filename'].'" download>Download</a>
                                </div>
                                ';
                        }
                    }
                    else{
                        echo 'Tidak ada riwayat pemesanan tempat...';
                    }
                ?>
            </div>
        </div>
    </body>
</html>