<?php
    $user = 'root';
    $pass = '';
    $dbName = '20211_wp2_412019037';
    try {
        $db = new PDO('mysql:host=localhost;dbname='.$dbName, $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>