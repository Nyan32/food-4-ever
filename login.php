<?php
    session_start();
    if(isset($_SESSION['userID'])){
        unset($_SESSION['userID']);
    }
    $_SESSION['pesanan_sementara']=array();
?>
<!DOCTYPE html>
<html translate="no">
    <head>
        <?php include('_library/lib-include.php')?>
        <title>Login | Food4Ever</title>
        <link type="text/css" href="_library/css/login-register.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/login.js"></script>
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
                            <h1>LOGIN</h1>
                            <hr>
                            <div id="notification" class="container-fluid alert"></div>
                            <form>
                                <div class="py-3">
                                    <label id="emailLabel" class="input-label" for="email">Email</label>
                                    <input id="email" name="email" autocomplete="email username" type="text" class="input-text"/> 
                                    <p id="emailAlert" class="alert-note"></p>   
                                </div>
                                <div class="py-3">
                                    <label id="passwordLabel" class="input-label" for="password">Password</label>
                                    <input id="password" name="password" type="password" autocomplete="current-password" class="input-text"/>
                                    <p id="passwordAlert" class="alert-note"></p>    
                                </div>
                                <p class="text-center p-5">
                                    <button id="btnLogin" type="button" name="submitLog" class="clean-btn rounded-pill btn-style-2 p-3 icon-login">&nbspLogin</button>
                                    <br>
                                    <p class="text-center">Belum memiliki akun? <a href="register.php">Register</a></p>
                                </p>
                            </form>
                        </div>
                        <p class="text-center m-0"><a href="administrator/index.php">Login Admin</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>