<?php
    session_start();
    include('_dbconfig/dbConfig.php');
?>

<!DOCTYPE html>
<html translate="no">
    <head>
        <?php include('_library/lib-include.php')?>
        <title>Tentang Kami | Food4Ever</title>
        <link type="text/css" href="_library/css/aboutUs.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/aboutUs.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <div style="min-height:100vh">
            <div class="d-flex justify-content-between align-items-center px-2"> 
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-left.svg"/>
                </div>
                <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>

                <h1 class="text-center m-0 px-2 flex-grow-1">Tentang Kami</h1>

                <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                    <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                </div>
                <div class="d-flex align-items-center">
                    <img src="administrator/img/style/arrow-right.svg"/>
                </div>
            </div>

            <div class="d-flex justify-content-center flex-wrap">
                <span class="d-flex align-items-center p-2"><button id="restoranBtn" class="clean-btn rounded-pill btn-style-1 p-2">&nbspRestoran</button></span>
                <span class="d-flex align-items-center p-2"><button id="devBtn" class="clean-btn rounded-pill btn-style-1 p-2">&nbspDeveloper</button></span>
            </div>

            <div id="restoranCont" class="d-flex flex-column align-items-center">
                <div class="d-flex justify-content-center">
                    <div style="width:200px; height:200px">
                        <img src="administrator/img/logo/food4Ever_logo_colored_detail.svg" style="width: 100%; height:100%; object-fit: contain;"/>
                    </div>
                </div>
                <br>
                <h2 class="text-center">Restoran</h2>
                <p class="text-center penjelasan-singkat p-2">Food4Ever adalah restoran unik yang siap memanjakan para pelanggan. Dengan varian menunya yang beragam ditambah dengan koki-koki ternama membuat anda sekalian menikmati setiap gigitan makanan yang ada. Restoran ini memiliki pemandangan yang bagus dengan live band terkemuka membuat anda menikmati hidangan anda. Higenitas adalah nomor satu di restoran kami agar kualitas makanan anda terjamin. </p>

                <h2 class="text-center">Galeri Foto</h2>
                <div id="carouselExampleControls" class="carousel slide gallery-foto" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height: 100%;">
                    <?php
                        $stmt = $db->prepare('SELECT * FROM gallery_foto_restaurant_tb');
                        $stmt->execute();
                        $img = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        echo'
                        <div class="carousel-item active" style="height: 100%;">
                            <img src="administrator/img/restoran/'.$img[0]['nama_foto'].'" class="d-block w-100 h-100" style="object-fit: cover;">
                        </div>
                        ';
                        for($i=1;$i<count($img);$i++){
                            echo'
                            <div class="carousel-item" style="height: 100%;">
                                <img src="administrator/img/restoran/'.$img[$i]['nama_foto'].'" class="d-block w-100 h-100" style="object-fit: cover;">
                            </div>
                            ';
                        }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div id="developerCont" class="d-none flex-column align-items-center">
                <div class="d-flex justify-content-center">
                    <div style="width:200px; height:200px">
                        <img src="administrator/img/style/developer.jpeg" class="rounded-circle" style="width: 100%; height:100%; object-fit: cover; object-position:0 20px"/>
                    </div>
                </div>
                <br>
                <h2 class="text-center">Developer</h2>
                <p class="text-center penjelasan-singkat p-2">Perkenalkan saya adalah Oscar Deladas dengan NIM 412019037. Saya adalah developer website restoran ini. Saya berkuliah di Universitas Kristen Krida Wacana dan mengambil jurusan Informatika. Saya lahir di Jakarta pada tanggal 26 Juli 2001.</p>
            </div>
        </div>
        <br>
        <?php include('_framework/footer.php') ?>
    </body>
</html>