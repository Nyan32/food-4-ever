<?php
    session_start();
    if(isset($_SESSION['adminID'])){
        unset($_SESSION['adminID']);
    }
    include('../_dbconfig/dbConfig.php');

    if(isset($_POST['loginSubmit']) && isset($_POST['email']) && isset($_POST['password'])){
        $everythingIsValidated = 1;

        $response = array('validasi'=>array('email' => 0,
                                            'password' => 0),
                          'status'=>0);

        $email = trim(strtolower($_POST['email']));
        $password = $_POST['password'];

        if($email!=''){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response['validasi']['email']=1;
            }
            else{
                $response['validasi']['email']=2;
                $everythingIsValidated = 0;
            }
        }
        else{
            $everythingIsValidated = 0;
        }

        if($password!=''){
            $response['validasi']['password']=1;
        }
        else{
            $everythingIsValidated = 0;
        }

        if($everythingIsValidated==1){
            $stmt = $db->prepare('SELECT COUNT(*) FROM admin_tb WHERE email= :email');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
            $stmt->execute();
            $numOfEmail = $stmt->fetch(PDO::FETCH_NUM);

            if($numOfEmail[0]<1){
                $response['status'] = 2;
                header('Location:login.php?status='.$response['status']);
            }
            else{
                $stmt = $db->prepare('SELECT pass= :password, email FROM admin_tb WHERE email= :email');
                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR, 50);
                $stmt->execute();
                $return = $stmt->fetch(PDO::FETCH_NUM);
                if($return[0]==1){
                    $_SESSION['pesanan_sementara'] = array();
                    $_SESSION['adminID'] = hash('sha256', $return[1]);
                    $response['status'] = 1;
                    header('Location:index.php');
                }
                else{
                    $response['status'] = 2;
                    header('Location:login.php?status='.$response['status']);
                }
            }
        }
        else{
            header('Location:login.php?status='.$response['status'].'&staEm='.$response['validasi']['email'].'&staPas='.$response['validasi']['password']);
        }
    }
?>

<!DOCTYPE html>

<html class="notranslate" translate="no">
    <head>
        <?php include("_library/lib-include.php") ?>
        <script src="_library/js/login.js"></script>
        <link href="_library/css/login.css" rel="stylesheet"/>
        <title>Login | Database Food4Ever</title>
    </head>

    <body>
        <div class="w-100 d-flex align-items-center justify-content-center" style="min-height:100vh">
            <div class="bg-light p-4 rounded border">
                <h1>Login Admin</h1>
                <p>Selamat datang ke database!</p>
                <form method="POST" action="">
                    <div>
                        <label>Email Admin</label>
                        <input class="form-control" id="email" name="email" type="text"/>
                        <p id="emailAlert" class="font-danger" style="font-size:0.8em; color: red"><?php
                            if(isset($_GET['status']) && $_GET['status']==0){
                                if(isset($_GET['staEm'])){
                                    if($_GET['staEm']==0){
                                        echo'Field tidak boleh kosong';
                                    }
                                    else if($_GET['staEm']==2){
                                        echo'Gunakan format email yang standar';
                                    }
                                }
                            }
                        ?></p><label>Password</label>
                        <input class="form-control" id="email" name="password" type="password">
                        <p id="passAlert" class="font-danger" style="font-size:0.8em; color: red"><?php
                            if(isset($_GET['status']) && $_GET['status']==0){
                                if(isset($_GET['staPas'])){
                                    if($_GET['staPas']==0){
                                        echo'Field tidak boleh kosong';
                                    }
                                }
                            }
                        ?></p><br>
                        <button type="submit" name="loginSubmit" class="btn btn-primary form-control">Masuk</button>
                    </div>
                </form>
                <?php
                    if(isset($_GET['status']) && $_GET['status']==2){
                        echo '<p id="emailAlert" class="font-danger text-center" style="font-size:0.8em; color: red">Email atau password admin salah</p>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>