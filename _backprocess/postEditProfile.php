<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    if(isset($_POST['namaLengkap']) && isset($_POST['nomorTelepon']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['imgStatus']) && isset($_POST['alamat'])){
        $response = array('validasi'=>array('namaLengkap' => 0,
                                            'alamat' => 0,
                                            'nomorTelepon' => 0,
                                            'email' => 0,
                                            'password' => 0,
                                            'imgStatus'=> 0),
                      'status'=>0);
        $everythingIsValidated = 1;

        $namaLengkap = trim(ucwords(strtolower($_POST['namaLengkap'])));
        $alamat = trim(strtoupper($_POST['alamat']));
        $nomorTelepon = trim($_POST['nomorTelepon']);
        $email = trim(strtolower($_POST['email']));
        $password = $_POST['password'];
        $imgStatus = $_POST['imgStatus'];

        $allowedExt = ['jpg','png','jpeg'];
        $regexAlphaandDot = '/^[a-z. ]+$/i';
        $regexAlamat= '/^[a-z0-9.\- \/,]+$/i';
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

        if($alamat!=''){
            if(preg_match($regexAlamat, $alamat)==1){
                $response['validasi']['alamat']=1;
            }
            else{
                $response['validasi']['alamat']=2;
                $everythingIsValidated = 0;
            }
        }
        else{
            $response['validasi']['alamat']=1;
            $alamat = null;
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

        if($imgStatus==0 || $imgStatus==1 || $imgStatus==2){
            if($imgStatus==1){
                $ext = pathinfo($_FILES['gambarProfil']['name'], PATHINFO_EXTENSION);
                $result = array_search($ext, $allowedExt);
                if($result===false){
                    $everythingIsValidated = 0;
                    $response['validasi']['imgStatus']=1;
                }
            }
        }
        else{
            $everythingIsValidated = 0;
        }

        if($everythingIsValidated==1){
            $target_dir = dirname(__FILE__).'/../administrator/img/profil/';
            $userID = $_SESSION['userID'];
            $stmt = $db->prepare('SELECT COUNT(*), id, gambar_profil FROM account_tb WHERE SHA2(email, 256)=:email');
            $stmt->bindParam(':email', $userID);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_NUM);

            if($data[0]==1){
                $stmt1 = $db->prepare('SELECT COUNT(*) FROM account_tb WHERE email=:email AND id!=:id');
                $stmt1->bindParam(':id', $data[1], PDO::PARAM_INT, 255);
                $stmt1->bindParam(':email', $email, PDO::PARAM_STR, 50);
                $stmt1->execute();
                $countEmailExSelf = $stmt1->fetch(PDO::FETCH_NUM);

                if($countEmailExSelf[0]<1){
                    if($imgStatus==1){
                        if($data[2]!='no-photo.png'){
                            $deletePhoto = $target_dir.$data[2];
                            unlink($deletePhoto);
                        }
                        $filename = $data[1].'.'.$ext;
                        $stmt = $db->prepare('UPDATE account_tb SET email=:email, gambar_profil=:filename, password=:password WHERE id=:id');
                        $stmt->bindParam(':id', $data[1], PDO::PARAM_INT, 255);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
                        $stmt->bindParam(':filename', $filename, PDO::PARAM_STR, 255);
                        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 50);
                    }
    
                    else if($imgStatus==2){
                        if($data[2]!='no-photo.png'){
                            $deletePhoto = $target_dir.$data[2];
                            unlink($deletePhoto);
                        }
                        $stmt = $db->prepare('UPDATE account_tb SET email=:email, gambar_profil=DEFAULT(gambar_profil), password=:password WHERE id=:id');
                        $stmt->bindParam(':id', $data[1], PDO::PARAM_INT, 255);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
                        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 50);
                    }

                    else if($imgStatus==0){
                        $stmt = $db->prepare('UPDATE account_tb SET email=:email, password=:password WHERE id=:id');
                        $stmt->bindParam(':id', $data[1], PDO::PARAM_INT, 255);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
                        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 50);
                    }
    
                    if($stmt->execute()){
                        if($imgStatus==1){
                            move_uploaded_file($_FILES['gambarProfil']['tmp_name'], $target_dir.$filename);
                        }

                        $_SESSION['userID'] = hash('sha256', $email);
    
                        $stmt = $db->prepare('UPDATE personal_info_tb SET nama_lengkap=:nama_lengkap, no_telepon=:no_telepon, alamat=:alamat WHERE account_id=:id');
                        $stmt->bindParam(':id', $data[1], PDO::PARAM_INT, 255);
                        $stmt->bindParam(':nama_lengkap', $namaLengkap, PDO::PARAM_STR, 50);
                        $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR, 255);
                        $stmt->bindParam(':no_telepon', $nomorTelepon, PDO::PARAM_STR, 12);
                        
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
    }
    echo json_encode($response);
    unset($stmt);
    unset($db);
?>