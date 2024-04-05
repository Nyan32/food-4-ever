<?php
    session_start();
    unset($_SESSION['userID']);
    $_SESSION['pesanan_sementara']=array();
?>
<!DOCTYPE html>
<html translate="no">
    <head>
        <?php include('_library/lib-include.php')?>
        <title>Register | Food4Ever</title>
        <link type="text/css" href="_library/css/login-register.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/register.js"></script>
    </head>
    <body>
        <div class="container-fluid row m-0 p-0">
            <div class="col-md-6 col-12">

            </div>
            <div class="col-md-6 col-12 m-0 p-0">
                <div class="d-flex justify-content-end">
                    <div class="form-area bg-light p-1">
                    <p class="m-0"><a href="index.php"><span class="icon-left-big" style="text-decoration: none;"></span>Ke Halaman Utama</a></p>
                        <div class="p-4">
                            <h1>REGISTER</h1>
                            <hr>
                            <div id="notification" class="container-fluid alert"></div>
                            <form>
                                <div class="py-3">
                                    <label id="namaLengkapLabel" class="input-label" for="namaLengkap">Nama Lengkap</label>
                                    <input id="namaLengkap" name="namaLengkap" autocomplete="name" type="text" class="input-text"/>
                                    <p id="namaLengkapAlert" class="alert-note"></p>   
                                </div>
                                <div class="py-3">
                                    <label id="nomorTeleponLabel" class="input-label" for="nomorTelepon">Nomor Telepon</label>
                                    <input id="nomorTelepon" name="nomorTelepon" autocomplete="tel" type="text" class="input-text"/> 
                                    <p id="nomorTeleponAlert" class="alert-note"> </p>   
                                </div>
                                <div class="py-3">
                                    <label id="emailLabel" class="input-label" for="email">Email</label>
                                    <input id="email" name="email" autocomplete="email username" type="text" class="input-text"/>    
                                    <p id="emailAlert" class="alert-note"></p>
                                </div>
                                <div class="py-3">
                                    <label id="passwordLabel" class="input-label" for="password">Password</label>
                                    <input id="password" name="password" autocomplete="new-password" type="password" class="input-text"/>    
                                    <p id="passwordAlert" class="alert-note"></p>
                                </div>
                                <p class="text-center p-5">
                                    <button id="submitBtn" type="button" name="submitReg" class="clean-btn rounded-pill btn-style-2 p-3 icon-user-plus">&nbspRegister</button>
                                    <br>
                                    <p class="text-center">Sudah memiliki akun? <a href="login.php">Login</a></p>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>