<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    $response = array('table'=>null);

    if(isset($_GET['id'])){
        $selTable = $_GET['id'];

        $stmt = $db->prepare('SELECT *, COUNT(*) AS jumlah FROM reserve_table_tb WHERE id=:selTable');
        $stmt->bindParam(':selTable', $selTable, PDO::PARAM_INT, 255);
        $stmt->execute();
        $table = $stmt->fetch(PDO::FETCH_ASSOC);

        $table['harga'] = 'Rp. '.number_format($table['harga'], 0, '.', ',');

        $response['table'] = $table;
    }
    else{
        $stmt = $db->prepare('SELECT id FROM reserve_table_tb WHERE status="tersedia"');
        $stmt->execute();
        $firstID = $stmt->fetch(PDO::FETCH_ASSOC);

        $selTable = $firstID['id'];

        $stmt = $db->prepare('SELECT *, COUNT(*) AS jumlah FROM reserve_table_tb WHERE id=:selTable');
        $stmt->bindParam(':selTable', $selTable, PDO::PARAM_INT, 255);
        $stmt->execute();
        $table = $stmt->fetch(PDO::FETCH_ASSOC);

        $table['harga'] = 'Rp. '.number_format($table['harga'], 0, '.', ',');

        $response['table'] = $table;
    }

    echo json_encode($response);
    unset($stmt);
    unset($db);
?>