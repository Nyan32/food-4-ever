<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT a.*, b.*, COUNT(*) AS count_acc FROM account_tb a JOIN personal_info_tb b ON a.id = b.account_id WHERE SHA2(a.email ,256) = :email');
    $stmt->bindParam(':email', $_SESSION['userID']);
    $stmt->execute();
    
    $personal_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if($personal_info['count_acc']==0){
        header('Location:notLoggedIn.php');
    }
?>

<!DOCTYPE html>
<html translate="no">
    <head> 
        <?php include('_library/lib-include.php')?>
        <title>Riwayat | Food4Ever</title>
        <script type="text/javascript" src="_library/js/history.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div style="min-height: 100vh;">
            <div class="d-flex justify-content-between align-items-center px-2">
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="text-center m-0 px-2 flex-grow-1">Riwayat</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>
            <div class="p-2">
                <div class="d-flex justify-content-center flex-wrap">
                    <span class="d-flex align-items-center p-2"><button id="makananBtn" class="clean-btn rounded-pill btn-style-1 p-2">&nbsp;Makanan</button></span>
                    <span class="d-flex align-items-center p-2"><button id="tempatBtn" class="clean-btn rounded-pill btn-style-1 p-2">&nbsp;Tempat</button></span>
                </div>

                <div id="contRiwayat">
                    <?php
                        $stmt = $db->prepare('SELECT * FROM purchase_history_tb WHERE acc_id=(SELECT id FROM account_tb WHERE SHA2(email, 256)=:email) ORDER BY tanggal_beli DESC ');
                        $stmt->bindParam(':email', $_SESSION['userID']);
                        $stmt->execute();
                        $purHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if(count($purHistory)>0){
                            for($i=0;$i<count($purHistory);$i++){
                            
                                echo'   
                                <div class="d-flex py-2 flex-wrap align-items-stretch w-100" style="border-bottom:solid 1px #aa4400">
                                    <div class="d-flex flex-column p-2 col-12 col-sm-10 col-md-11">
                                        <div class="text-wrap text-break w-100">'.$purHistory[$i]['alamat'].'</div>
                                        <div class="text-truncate w-100">'.$purHistory[$i]['tanggal_beli'].'</div>
                                        <div class="text-truncate w-100 d-inline-block">Receipt: '.$purHistory[$i]['receipt_code'].'</div>
                                    </div>
                                    <a class="clean-btn btn-style-2 ft-white-1 p-2 receipt-btn flex-grow-1 col-12 col-sm-2 col-md-1 d-flex justify-content-center align-items-center" style="text-decoration:none; color:white !important" href="administrator/receipt/makanan/'.$purHistory[$i]['filename'].'" download>Receipt</a>
                                </div>
                                
                                ';
                            }
                        }
                        else{
                            echo 'Tidak ada riwayat pembelian.';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>