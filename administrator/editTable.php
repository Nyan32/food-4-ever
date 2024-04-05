<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){
        if(isset($_POST['namaTable']) && isset($_POST['kapasitasTable']) && isset($_POST['deskripsiTable']) &&  isset($_POST['statusTable']) && isset($_POST['posisiTable']) && isset($_POST['submitBtn']) && isset($_POST['id'])){

            $namaTable = trim(strip_tags(ucwords(strtolower($_POST['namaTable']))));
            $posisiTable = trim(strip_tags($_POST['posisiTable']));
            $kapasitasTable = strip_tags(trim($_POST['kapasitasTable']));
            $hargaTable = strip_tags(trim($_POST['hargaTable']));
            $deskripsiTable = strip_tags(trim($_POST['deskripsiTable']));
            $statusTable = $_POST['statusTable'];

            if($namaTable!='' && $kapasitasTable!='' && $posisiTable!=''){
                $stmt = $db->prepare('UPDATE reserve_table_tb SET nama_meja=:namaTable, kapasitas=:kapasitasTable, harga=:hargaTable, posisi=:posisiTable, deskripsi=:deskripsiTable, status=:statusTable WHERE id =:id');
                $stmt->bindParam(':namaTable', $namaTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':kapasitasTable', $kapasitasTable, PDO::PARAM_INT, 10);
                $stmt->bindParam(':hargaTable', $hargaTable, PDO::PARAM_INT, 10);
                $stmt->bindParam(':posisiTable', $posisiTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':deskripsiTable', $deskripsiTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':statusTable', $statusTable, PDO::PARAM_STR, 50);
                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT, 255);
                if($stmt->execute()){
                    header('Location: addEditTable.php?id='.$_POST['id'].'&sucessfull=1');
                }
            }
            else{
                header('Location: addEditTable.php?id='.$_POST['id'].'&sucessfull=0');
            } 
        }
    }
?>