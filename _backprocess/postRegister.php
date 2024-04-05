<?php
    include('../_dbconfig/dbConfig.php');
    if(isset($_POST['namaLengkap']) && isset($_POST['nomorTelepon']) && isset($_POST['email']) && isset($_POST['password'])){
        $everythingIsValidated = 1;
        $response = array('validasi'=>array('namaLengkap' => 0,
                                            'nomorTelepon' => 0,
                                            'email' => 0,
                                            'password' => 0),
                          'status'=>0);

        $namaLengkap = trim(ucwords(strtolower($_POST['namaLengkap'])));
        $nomorTelepon = trim($_POST['nomorTelepon']);
        $email = trim(strtolower($_POST['email']));
        $password = $_POST['password'];

        $regexAlphaandDot = '/^[a-z. ]+$/i';
        $regexAlpha = '/^[a-z ]+$/i';
        $regexAlphaNum = '/^[a-z0-9 ]+$/i';
        $regexNum = '/^[0-9]+$/';

        if($namaLengkap!=''){
            if(preg_match($regexAlphaandDot, $namaLengkap)==1){
                $response['validasi']['namaLengkap']=1;
            }
            else{
                $response['validasi']['namaLengkap']=2;
                $everythingIsValidated = 0;
            }
        }
        else{
            $everythingIsValidated = 0;
        }

        if($nomorTelepon!=''){
            if(preg_match($regexNum, $nomorTelepon)==1){
                $response['validasi']['nomorTelepon']=1;
            }
            else{
                $response['validasi']['nomorTelepon']=2;
                $everythingIsValidated = 0;
            }
        }
        else{
            $everythingIsValidated = 0;
        }

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
            if(strlen($password)<8){
                $response['validasi']['password']=2;
                $everythingIsValidated = 0;
            }
            else{
                $response['validasi']['password']=1;
            }
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
                $stmt = $db->prepare('INSERT INTO account_tb VALUES (NULL, :email, DEFAULT(gambar_profil),:password)');
                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR, 255);
                
                if($stmt->execute()){
                    $accId = $db->lastInsertId();
                    $stmt = $db->prepare('INSERT INTO personal_info_tb VALUES (NULL, :nama_lengkap, :no_telepon, NULL, :account_id)');
                    $stmt->bindParam(':nama_lengkap', $namaLengkap, PDO::PARAM_STR, 50);
                    $stmt->bindParam(':no_telepon', $nomorTelepon, PDO::PARAM_STR, 12);
                    $stmt->bindParam(':account_id', $accId, PDO::PARAM_INT, 255);
                    
                    if($stmt->execute()){
                        $response['status'] = 1;
                    }
                }
            }

            else{
                $response['status'] = 2;
            }
        }
    }
    echo json_encode($response);
    unset($stmt);
    unset($db);
?>