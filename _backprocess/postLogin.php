<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    if(isset($_POST['email']) && isset($_POST['password'])){
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
            $stmt = $db->prepare('SELECT COUNT(*) FROM account_tb WHERE email= :email');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
            $stmt->execute();
            $numOfEmail = $stmt->fetch(PDO::FETCH_NUM);

            if($numOfEmail[0]<1){
                $response['status'] = 2;
            }
            else{
                $stmt = $db->prepare('SELECT password= :password, email FROM account_tb WHERE email= :email');
                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR, 255);
                $stmt->execute();
                $return = $stmt->fetch(PDO::FETCH_NUM);
                if($return[0]==1){
                    $_SESSION['pesanan_sementara'] = array();
                    $_SESSION['userID'] = hash('sha256', $return[1]);
                    $response['status'] = 1;
                }
                else{
                    $response['status'] = 2;
                }
            }
        }
    }
    echo json_encode($response);
    unset($stmt);
    unset($db);
?>