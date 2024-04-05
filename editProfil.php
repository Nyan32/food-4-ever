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
        <title>Ubah Profil | Food4Ever</title>
        <link type="text/css" href="_library/css/editProfil.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/editProfil.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div id="notification" class="w-100 d-flex justify-content-between align-items-center alert d-none"></div>
        <div class="d-flex flex-column justify-content-center align-items-center w-100" style="min-height:100vh">
            <div class="d-flex justify-content-between align-items-center px-2 w-100">
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="mb-0 px-2 flex-grow-1 text-center">Ubah Profil</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>    

            <form class="form-edit p-2" autocomplete="off">
                <div class="d-flex flex-column align-items-center py-3 text-center">
                    <input id="fotoFileSubmit" type="file" hidden/>
                    <input id="imgStatus" data-imageProfil="<?php echo $personal_info['gambar_profil'].'?dummy='.filemtime(dirname(__FILE__).'/administrator/img/profil/'.$personal_info['gambar_profil']) ?>" value="0" hidden/>

                    <div style="width:120px; height:120px;" class="p-2">
                        <img id="imgProfilReview" src="administrator/img/profil/<?php echo $personal_info['gambar_profil'].'?dummy='.filemtime(dirname(__FILE__).'/administrator/img/profil/'.$personal_info['gambar_profil'])?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center">
                        <span class="p-2">
                            <button id="ubahFotoProfil" type="button" class="clean-btn rounded-pill p-2  btn-style-1">Ubah Foto</button>
                        </span>
                        <span class="p-2">
                            <button id="hapusFotoProfil" type="button" class="clean-btn rounded-pill p-2 btn-style-2">Hapus Foto</button>
                        </span>
                    </div>
                </div>
                <div class="py-3">
                    <label id="namaLengkapLabel" class="input-label" for="namaLengkap">Nama Lengkap</label>
                    <input id="namaLengkap" name="namaLengkap" type="text" class="input-text" value="<?php
                        echo $personal_info['nama_lengkap'];
                    ?>"/>
                    <p id="namaLengkapAlert" class="alert-note"></p>   
                </div>

                <div class="py-3">
                    <label id="alamatLabel" class="input-label" for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" type="text" class="input-text input-textarea"><?php
                        echo $personal_info['alamat'];
                    ?></textarea>
                    <p id="alamatAlert" class="alert-note"></p>   
                </div>

                <div class="py-3">
                    <label id="nomorTeleponLabel" class="input-label" for="nomorTelepon">Nomor Telepon</label>
                    <input id="nomorTelepon" name="nomorTelepon" type="text" class="input-text" value="<?php
                        echo $personal_info['no_telepon'];
                    ?>"/> 
                    <p id="nomorTeleponAlert" class="alert-note"></p>   
                </div>
                <div class="py-3">
                    <label id="emailLabel" class="input-label" for="email">Email</label>
                    <input id="email" name="email" type="text" class="input-text" value="<?php
                        echo $personal_info['email'];
                    ?>"/>    
                    <p id="emailAlert" class="alert-note"></p>
                </div>
                <div class="py-3">
                    <label id="passwordLabel" class="input-label" for="password">Password</label>
                    <input id="password" name="password" type="text" class="input-text" value="<?php
                        echo $personal_info['password'];
                    ?>"/>    
                    <p id="passwordAlert" class="alert-note"></p>
                </div>
                <p class="text-center p-5">
                    <button id="saveEditBtn" type="button" class="clean-btn p-2 icon-floppy rounded-pill btn-style-2">&nbspSimpan</button>
                </p>
            </form>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>