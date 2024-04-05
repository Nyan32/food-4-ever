<?php
    session_start();
    include('../_dbconfig/dbConfig.php');

    $stmt = $db->prepare('SELECT * FROM reserve_history_tb WHERE acc_id=(SELECT id FROM account_tb WHERE SHA2(email, 256)=:email) ORDER BY tanggal_dipesan DESC');
    $stmt->bindParam(':email', $_SESSION['userID']);
    $stmt->execute();
    $purHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($purHistory);
    unset($stmt);
    unset($db);
?>