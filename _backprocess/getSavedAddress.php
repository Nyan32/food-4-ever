<?php
    session_start();
    include('../_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT b.alamat FROM account_tb a JOIN personal_info_tb b ON a.id = b.account_id WHERE SHA2(a.email, 256)=:email');
    $stmt->bindParam(':email', $_SESSION['userID']);
    $stmt->execute();

    $alamat = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($alamat);
    unset($stmt);
    unset($db);
?>