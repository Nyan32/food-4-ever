<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT COUNT(*) AS count_acc FROM admin_tb WHERE SHA2(email ,256) = :email');
    $stmt->bindParam(':email', $_SESSION['adminID']);
    $stmt->execute();
    
    $personal_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if($personal_info['count_acc']==0){
        header('Location:login.php');
    }
?>

<!DOCTYPE html>

<html class="notranslate" translate="no">
    <head>
        <?php include("_library/lib-include.php")?>
        <title>Feedback | Database Food4Ever</title>
    </head>

    <body>
        <?php 
            include("_framework/header.php");
        ?>
        <h1 class="text-center">Feedback</h1>
        <div class="mt-3 p-2">
            <div class="mt-4">
                <?php 
                    echo'<div class="py-2">';
                    $stmt = $db->prepare('SELECT * FROM feedback_tb a JOIN account_tb b ON a.acc_id=b.id');
                    $stmt->execute();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(count($output)>0){
                        for($i=0; $i<count($output); $i++){
                            echo '
                            <div class="container-fluid m-0 border-bottom row p-2">
                                <div class="col-12 border-start d-flex align-items-center" style="text-decoration:underline; font-weight:bold">'.$output[$i]['email'].' said:</div>
                                
                                <div class="col-12  d-flex align-items-center border-start">
                                    '.$output[$i]['feedback_text'].'
                                </div>
                            </div>';
                        }
                    }
                    else{
                        echo 'Tidak ada feedback...';
                    }
                ?>
            </div>
        </div>
    </body>
</html>