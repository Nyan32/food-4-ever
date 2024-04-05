<?php
    session_start();
    if(isset($_POST['id']) && isset($_POST['ammount'])){
        $id = $_POST['id'];
        $ammount = $_POST['ammount'];
        if(!isset($_SESSION['pesanan_sementara'])){
            $_SESSION['pesanan_sementara'] = array();
        }

        if($ammount>0){
            if(array_key_exists($id, $_SESSION['pesanan_sementara'])){
                $_SESSION['pesanan_sementara'][$id] = $ammount;
            }
            else{
                $_SESSION['pesanan_sementara'] += [$id => $ammount];
            }
        }
        else{
            if(array_key_exists($id, $_SESSION['pesanan_sementara'])){
                unset($_SESSION['pesanan_sementara'][$id]);
            }
        }
    }
?>