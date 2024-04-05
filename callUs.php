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
        <title>Hubungi Kami | Food4Ever</title>
        <link type="text/css" href="_library/css/callUs.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/callUs.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div id="notification" class="w-100 d-flex justify-content-between align-items-center alert d-none"></div>
        <div style="min-height:100vh">
            <div class="d-flex justify-content-between align-items-center px-2">
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="text-center m-0 px-2 flex-grow-1">Hubungi Kami</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>
            <div class="w-100 d-flex flex-column align-items-center">
                <div class="d-flex flex-column container-md mx-0 align-items-center">
                    <div class="d-flex justify-content-center">
                        <div style="width:200px; height:200px">
                            <img src="administrator/img/logo/food4Ever_logo_colored_detail.svg" style="width: 100%; height:100%; object-fit: contain;"/>
                        </div>
                    </div>

                    <h2 class="text-center">Nomor Telepon</h2>
                    <ul class="text-center">
                        <li>(021) 23495903</li>
                        <li>+62 88293820001</li>
                    </ul>
                    <br>
                    <h2 class="text-center">Email</h2>
                    <ul class="text-center">
                        <li>customer_service@food4ever.com</li>
                        <li>oscar.412019037@civitas.ukrida.ac.id</li>
                    </ul>
                    <br>
                    <div class="py-2 form-call-us">
                        <p class="text-center p-2 m-0">Ingin memberikan apresiasi, kritik dan saran ke restoran kami? Anda dapat mengirimkannya melalui input dibawah</p>
                        <form class="p-2 w-100">
                            <label id="masukkanLabel" class="input-label" for="masukkan" style="text-decoration: underline;">Feedback:</label>
                            <textarea placeholder="Masukkan text..." id="masukkan" name="masukkan" type="text" class="input-text input-textarea w-100" style="font-size: 1em !important;"></textarea>
                            <div class="py-2 d-flex align-items-center">
                                <button id="kirimFeed" type="button" class="clean-btn btn-style-2 rounded-pill">Kirim</button>&nbsp;&nbsp;
                                <span id="masukkanAlert" class="alert-note"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('_framework/footer.php') ?>  
    </body>
</html>