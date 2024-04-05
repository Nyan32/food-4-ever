<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    $response = array('menu'=>null,
                      'pesanan_sementara'=>null);
                      
    if(isset($_SESSION['pesanan_sementara'])){
        $response['pesanan_sementara'] = $_SESSION['pesanan_sementara'];
    }

    if(isset($_GET['katID'])){
        $selKategori = $_GET['katID'];

        $stmt = $db->prepare('SELECT a.*, b.nama_kategori AS nama_kategori FROM menu_tb a JOIN kategori_tb b ON a.kategori_id=b.id WHERE b.id=:selKategori');
        $stmt->bindParam(':selKategori', $selKategori, PDO::PARAM_INT, 255);
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($menu);$i++){
           $menu[$i]['gambar_makanan'] = $menu[$i]['gambar_makanan'].'?dummy='.filemtime(dirname(__FILE__).'/../administrator/img/menu/'.$menu[$i]['gambar_makanan']);
           $menu[$i]['harga_makanan'] = 'Rp. '.number_format($menu[$i]['harga_makanan'], 0, '.', ',');
        }

        $response['menu'] = $menu;
    }
    else{
        $stmt = $db->prepare('SELECT DISTINCT a.* FROM kategori_tb a JOIN menu_tb b ON b.kategori_id=a.id WHERE a.id!=0');
        $stmt->execute();
        $firstID = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $db->prepare('SELECT a.*, b.nama_kategori AS nama_kategori FROM menu_tb a JOIN kategori_tb b ON a.kategori_id=b.id WHERE b.id=:firstID');
        $stmt->bindParam(':firstID', $firstID['id'], PDO::PARAM_INT, 255);
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($menu);$i++){
            $menu[$i]['gambar_makanan'] = $menu[$i]['gambar_makanan'].'?dummy='.filemtime(dirname(__FILE__).'/../administrator/img/menu/'.$menu[$i]['gambar_makanan']);
            $menu[$i]['harga_makanan'] = 'Rp. '.number_format($menu[$i]['harga_makanan'], 0, '.', ',');
        }

        $response['menu'] = $menu;
    }
    echo json_encode($response);
    unset($stmt);
    unset($db);
?>