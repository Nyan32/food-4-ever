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
        <title>Pesan Tempat | Food4Ever</title>
        <link type="text/css" href="_library/css/reserveTable.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/reserveTable.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div id="notification" class="w-100 d-flex justify-content-between align-items-center alert d-none"></div>
        <div class="d-flex flex-column align-items-center w-100" style="min-height:100vh">
            <div class="d-flex justify-content-between align-items-center px-2 w-100">
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="mb-0 px-2 flex-grow-1 text-center">Pesan Tempat</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>    

            <form class="form-edit p-2" autocomplete="off">
                <div class="py-3">
                    <label id="pilihMejaLabel" class="input-label" for="pilihMeja">Pilih Meja</label>
                    <select id="pilihMeja" name="pilihMeja" class="form-select">
                        <?php
                            $stmt = $db->prepare('SELECT * FROM reserve_table_tb WHERE status="tersedia"');
                            $stmt->execute();
                            $table = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            for($i=0;$i<count($table);$i++){
                                echo '<option value="'.$table[$i]['id'].'">'.$table[$i]['nama_meja'].'</option>';
                            }
                        ?>
                    </select>   
                </div>
                <div id="informationTable"></div>

                <div class="py-3">
                    <label id="tanggalPesananLabel" class="input-label" for="tanggalPesanan">Tanggal Pesanan</label>
                    <input id="tanggalPesanan" name="tanggalPesanan" type="datetime-local" class="input-text"/> 
                    <p id="tanggalPesananAlert" class="alert-note"></p>   
                </div>

                <div class="py-3 d-flex flex-column">
                    <div class="form-check">
                        <input id="persetujuan" name="persetujuan" type="checkbox" class="form-check-input" value="on"/>
                        <label id="persetujuanLabel" class="form-check-label">Dengan ini saya menyetujui bahwa ketidakhadiran saya dalam satu jam dari waktu pemesanan akan menghapus tempat saya dan uang tidak dapat dikembalikan.</label>
                    </div>
                    <p id="persetujuanAlert" class="alert-note"></p>   
                </div>
                <p class="text-center m-0">
                    <button id="reserveBtn" type="button" class="clean-btn p-2 rounded-pill btn-style-2">Sewa Sekarang</button>
                </p>
            </form>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>