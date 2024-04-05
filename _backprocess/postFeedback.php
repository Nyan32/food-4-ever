<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    $response = array('validasi'=>array('masukkan' => 0),
                      'status'=>0);

    if(isset($_POST['masukkan'])){
        $everythingIsValidated = 1;

        $masukkan = strip_tags(trim($_POST['masukkan']));
        $id = $_SESSION['userID'];

        if($masukkan!=''){
            $response['validasi']['masukkan']=1;
        }
        else{
            $everythingIsValidated = 0;
        }

        if($everythingIsValidated==1){
            $stmt = $db->prepare('SELECT COUNT(*), id FROM account_tb WHERE SHA2(email,256) = :email');
            $stmt->bindParam(':email', $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_NUM);

            if($data[0]>0){
                $stmt = $db->prepare('INSERT INTO feedback_tb VALUES (NULL, :feedback_text, :acc_id)');
                $stmt->bindParam(':acc_id', $data[1], PDO::PARAM_INT);
                $stmt->bindParam(':feedback_text', $masukkan, PDO::PARAM_STR);
                $stmt->execute();
                $response['status']=1;
            }
            else{
                $response['status']=2;
            }
        }
    }
    echo json_encode($response);
?>