<?php
    session_start();
    include('../_dbconfig/dbConfig.php');  
    $userID = $_SESSION['userID'];

    $stmt = $db->prepare('SELECT gambar_profil FROM account_tb WHERE SHA2(email,256) = :email');
    $stmt->bindParam(':email', $userID);
    $stmt->execute();
    $gambarProfil=$stmt->fetch(PDO::FETCH_ASSOC);
    $gambarProfil['gambar_profil'] = $gambarProfil['gambar_profil'].'?dummy='.filemtime(dirname(__FILE__).'/../administrator/img/profil/'.$gambarProfil['gambar_profil']);

    echo json_encode($gambarProfil);
    unset($db);
    unset($stmt);
?>