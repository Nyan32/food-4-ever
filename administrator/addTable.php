<?php
    session_start();
    include('_dbconfig/dbConfig.php');

    if(isset($_POST['submitBtn'])){  
        if(isset($_POST['namaTable']) && isset($_POST['kapasitasTable']) && isset($_POST['deskripsiTable']) &&  isset($_POST['statusTable']) && isset($_POST['posisiTable']) && isset($_POST['submitBtn']) && !isset($_POST['id'])){
            
            $namaTable = trim(strip_tags(ucwords(strtolower($_POST['namaTable']))));
            $posisiTable = trim(strip_tags($_POST['posisiTable']));
            $kapasitasTable = strip_tags(trim($_POST['kapasitasTable']));
            $deskripsiTable = strip_tags(trim($_POST['deskripsiTable']));
            $hargaTable = strip_tags(trim($_POST['hargaTable']));
            $statusTable = $_POST['statusTable'];

            if($namaTable!='' && $kapasitasTable!='' && $posisiTable!=''){
                $stmt = $db->prepare('INSERT INTO reserve_table_tb VALUES(NULL, :namaTable, :kapasitasTable, :hargaTable, :posisiTable, :deskripsiTable, :statusTable)');
                $stmt->bindParam(':namaTable', $namaTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':kapasitasTable', $kapasitasTable, PDO::PARAM_INT, 10);
                $stmt->bindParam(':hargaTable', $hargaTable, PDO::PARAM_INT, 10);
                $stmt->bindParam(':posisiTable', $posisiTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':deskripsiTable', $deskripsiTable, PDO::PARAM_STR, 255);
                $stmt->bindParam(':statusTable', $statusTable, PDO::PARAM_STR, 50);

                if($stmt->execute()){
                    header('Location: addEditTable.php?sucessfull=1');
                }
            }
            else{
                header('Location: addEditTable.php?sucessfull=0');
            }
        }
    }
?>