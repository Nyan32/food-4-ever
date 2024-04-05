<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT a.*, b.*, COUNT(*) AS count_acc, IFNULL(b.alamat, "-") AS alamat_ver FROM account_tb a JOIN personal_info_tb b ON a.id = b.account_id WHERE SHA2(a.email ,256) = :email');
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
        <title>Profil | Food4Ever</title>
        <link type="text/css" href="_library/css/profil.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/profil.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div class="d-flex" style="min-height:100vh;">
            <div class="d-none d-lg-block" style="width:20vw">
                <img src="administrator/img/style/bg-profil-side.jpg" class="profil-bg"/>
            </div>
            <div class="flex-grow-1" style="max-width:100vw">
                <div class="d-flex justify-content-between align-items-center px-2">
                    <div class="d-flex align-items-center">
                        <img src="administrator/img/style/arrow-left.svg"/>
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                        <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                    </div>

                    <h1 class="m-0 p-2 text-center flex-grow-1">Profil</h1>

                    <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                        <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="administrator/img/style/arrow-right.svg"/>
                    </div>
                </div>
                <div class="w-100 d-block d-lg-none" style="height:200px;">
                    <img src="administrator/img/style/bg-profil-top.jpg" class="profil-bg w-100"/>
                </div>
                <div class="d-flex justify-content-center w-100 position-relative" style="min-height: 100px;">
                    <img src="administrator/img/profil/<?php echo $personal_info['gambar_profil'].'?dummy='.filemtime(dirname(__FILE__).'/administrator/img/profil/'.$personal_info['gambar_profil'])?>" class="rounded-circle img-profil" style="width:120px; height:120px; z-index:30; top:-60px">
                </div>
                <div class="d-flex flex-column align-items-center text-center p-2">
                    <?php
                        echo'<h3 class="m-0 p-0 text-wrap text-break profil-cont">'.$personal_info['nama_lengkap'].'</h3>';
                        echo'<p class="m-0 p-0 text-wrap text-break profil-cont">'.$personal_info['email'].'</p>';
                        echo'<p class="m-0 p-0 text-wrap text-break profil-cont">'.$personal_info['no_telepon'].'</p>';
                        echo'<div class="py-4"><p class="m-0">Alamat Tersimpan:</p><p class="px-auto mx-auto my-0 overflow-auto text-wrap text-break profil-cont">'.$personal_info['alamat_ver'].'</p></div>';
                    ?>
                </div>
                <div class="d-flex justify-content-center flex-wrap">
                    <span class="d-flex align-items-center p-2"><button id="editBtn" class="clean-btn rounded-pill btn-style-1 p-2 icon-edit">&nbspUbah Profil</button></span>
                    <span class="d-flex align-items-center p-2"><button id="historyBtn" class="clean-btn rounded-pill btn-style-1 p-2 icon-clipboard">&nbspRiwayat Pesanan</button></span>
                    <span class="d-flex align-items-center p-2"><button id="logoutBtn" class="clean-btn rounded-pill btn-style-2 p-2 icon-logout">&nbspLogout</button></span>
                </div>
            </div>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>