<?php
    session_start();
    include('_dbconfig/dbConfig.php');
?>

<!DOCTYPE html>
<html translate="no">
    <head>
        <?php include('_library/lib-include.php')?>
        <title>Pesan Menu | Food4Ever</title>
        <link type="text/css" href="_library/css/index.css" rel="stylesheet"/>
        <script type="text/javascript" src="_library/js/index.js"></script>
    </head>
    <body>
        <?php include('_framework/header.php') ?>
        <?php include('_framework/modal-box.php') ?>
        <div class="d-flex" style="min-height:100vh">
            <div class="d-none d-lg-block bg-yellow-1 kategori-menu-side">
                <div class="d-flex flex-column position-sticky top-0 p-2" style="min-height:100vh;max-height:100vh;">
                    <div>
                        <h2 style="color: black;">Kategori</h2>
                        <hr class="m-0" style="color: black; padding: 0px 2px; opacity: 100%;"/>
                    </div>
                    
                    <div class="d-flex flex-column justify-content-start flex-grow-1 px-1" style=" overflow-y:auto;" id="kategoriContainerFull">
                        <ul>
                            <?php 
                                $stmt = $db->prepare('SELECT DISTINCT a.* FROM kategori_tb a JOIN menu_tb b ON b.kategori_id=a.id');
                                $stmt->execute();
                                $kategori = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                for($i=0;$i<count($kategori);$i++){
                                    if($kategori[$i]['id']!=0){
                                        echo'
                                        <li>
                                            <button data-idKategori="'.$kategori[$i]['id'].'" class="d-flex align-items-center w-100 my-1 py-1 clean-btn kategori-btn kategoriBtn">
                                                <div class="img-kategori-cont flex-fill">
                                                    <img class="img-kategori rounded-circle" src="administrator/img/kategori_menu/'.$kategori[$i]['nama_foto'].'?dummy='.filemtime(dirname(__FILE__).'/administrator/img/kategori_menu/'.$kategori[$i]['nama_foto']).'"/>
                                                </div>
                                                <div class="p-2 btn-kategori-text d-block text-wrap text-break text-start">'.$kategori[$i]['nama_kategori'].'</div>
                                            </button>
                                        </li>
                                        ';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex-grow-1 d-flex flex-column" style="min-height:100vh">
                <div id="titleKategoriScroll" class="d-flex justify-content-between align-items-center p-2" style="min-height: 10vh;">
                    
                    <div class="d-flex align-items-center">
                        <img src="administrator/img/style/arrow-left.svg"/>
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center" style="height: 10px;">
                        <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                    </div>

                    <h1 id="titleKategori" class="text-center m-0 p-2 flex-grow-1 text-wrap"></h1>

                    <div class="flex-grow-1 d-flex align-items-center" style="height:10px;">
                        <img src="administrator/img/style/line.svg" style="height:100%; width:100%; object-fit:cover"/>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="administrator/img/style/arrow-right.svg"/>
                    </div>
                </div>

                <div class="d-flex flex-column flex-grow-1" style="min-height: 90vh;">
                    <div id="menuContainer" class="flex-grow-1 p-1 d-flex flex-wrap" style="align-content: flex-start;"></div>

                    <div class="d-flex flex-column position-sticky bottom-0 w-100" style="z-index:30;max-width:100vw;">
                        <div id="kategoriMinList" class="bg-yellow-1 position-relative bottom-0 d-none overflow-hidden" style="z-index:-30; border-top:solid black 2px;">
                            <div>
                                <ul>
                                    <?php 
                                        for($i=0;$i<count($kategori);$i++){
                                            if($kategori[$i]['id']!=0){
                                                echo'
                                                <li>
                                                    <button data-idKategori="'.$kategori[$i]['id'].'" class="d-flex align-items-center w-100 my-1 py-1 clean-btn kategori-btn kategoriBtn" style="padding-right:15px">
                                                        <span class="icon-food"></span>
                                                        <div class="p-2 btn-kategori-text d-block text-wrap text-break text-start">'.$kategori[$i]['nama_kategori'].'</div>
                                                    </button>
                                                </li>
                                                ';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch" style="min-height: 50px;">
                            <button id="kategoriListBtn" class="d-flex d-lg-none align-items-center clean-btn btn-style-1">Kategori</button>    
                            <button id="checkOutBtn" class="w-100 clean-btn btn-style-2 btn-check-out icon-basket">&nbspCheck Out</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <?php include('_framework/footer.php') ?>
    </body>
</html>