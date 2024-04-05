<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT COUNT(*) AS count_acc FROM account_tb WHERE SHA2(email ,256) = :email');
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
        <title>Checkout | Food4Ever</title>
        <link type="text/css" href="_library/css/checkout.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/checkout.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div id="notification" class="w-100 alert d-none"></div>
        <div class="d-flex flex-column" style="min-height: 100vh;">
            <div class="d-flex justify-content-between align-items-center px-2">
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="text-center m-0 px-2 flex-grow-1">Checkout</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>
            <div class="p-2 flex-grow-1 d-flex flex-column">
                <div class="flex-grow-1">
                    <?php
                        $pesananSementara = $_SESSION['pesanan_sementara'];
                        $key = array_keys($pesananSementara);
                        $finalTotal = 0;

                        for($i=0;$i<count($pesananSementara);$i++){
                            $ammount = $pesananSementara[$key[$i]];

                            $stmt = $db->prepare('SELECT nama_makanan, harga_makanan*:ammount AS total,FORMAT(harga_makanan*:ammount,"C","id-ID") AS total_format FROM menu_tb WHERE id=:id');

                            $stmt->bindParam(':ammount', $ammount, PDO::PARAM_INT);
                            $stmt->bindParam(':id', $key[$i], PDO::PARAM_INT, 255);
                            $stmt->execute();

                            $output = $stmt->fetch(PDO::FETCH_ASSOC);
                            $finalTotal = $finalTotal + $output['total'];
                            echo'  
                            <div class="d-flex py-2 flex-wrap align-items-stretch w-100" style="border-bottom:solid 1px #aa4400">
                                <div class="d-flex flex-column p-2 col-12 col-sm-10 col-md-10">
                                    <div class="text-wrap text-break w-100">'.$ammount.'x</div>
                                    <div class="text-wrap text-break w-100">'.$output['nama_makanan'].'</div>
                                </div>
                                <div class="d-flex align-items-center text-break p-2 receipt-btn flex-grow-1 col-12 col-sm-2 col-md-2">Rp. '.$output['total_format'].'</div>
                            </div>

                            ';
                        }
                    ?>
                    <h3 class="py-2 text-break" style="font-size: 100%;">
                        Total: <?php echo 'Rp. '.number_format($finalTotal, 0, '.', ',')?>
                    </h3>
                </div>
                <div class="py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <label id="alamatLabel" class="input-label" for="alamat">Alamat:</label>
                        <button id="dataAlamatBtn" class="clean-btn rounded-pill p-1 btn-style-1">
                            Gunakan Alamat Tersimpan
                        </button>
                    </div>
                    
                    <textarea id="alamat" name="alamat" type="text" class="input-text input-textarea" placeholder="Masukkan alamat..."></textarea>
                    <p id="alamatAlert" class="alert-note"></p>   
                </div>
                <div class="text-center">
                    <button id="orderNowBtn" class="clean-btn btn-style-2 rounded-pill p-2">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>