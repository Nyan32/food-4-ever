<header>
    <div class="m-0 p-1 bg-light w-100 d-flex align-items-stretch flex-column flex-md-row justify-content-between"
        style="border-bottom: 2px black solid;">
        <button class="p-1 header-home-btn" id="homeBtn"><img class="img-fluid"
                src="administrator/img/logo/food4Ever_logo_colored_detail.svg"
                style="max-width: 150px; min-width:100px; width:auto" /></button>

        <div class="d-lg-flex d-none align-items-stretch w-100 justify-content-end">
            <ul class="header-list d-flex justify-content-end w-100 h-100 align-items-stretch">
                <li class="px-2">
                    <button class="h-100 pesanMenuBtn">Pesan Menu</button>
                </li>
                <li class="px-2">
                    <button class="h-100 pesanTempatBtn">Pesan Tempat</button>
                </li>
                <li class="px-2">
                    <button class="h-100 aboutUsBtn">Tentang Kami</button>
                </li>
                <li class="px-2">
                    <button class="h-100 calllUsBtn">Hubungi Kami</button>
                </li>
                <li class="px-2">
                    <button class="foto-profil-btn-hor h-100 d-flex align-items-center <?php
                    if (isset($_SESSION['userID'])) {
                        echo 'profilBtn';
                    } else {
                        echo 'loginBtn';
                    }
                    ?>"><?php
                    if (isset($_SESSION['userID'])) {
                        $stmt = $db->prepare('SELECT gambar_profil FROM account_tb WHERE SHA2(email, 256)=:email');
                        $stmt->bindParam(':email', $_SESSION['userID']);
                        $stmt->execute();

                        $gambarProfil = $stmt->fetch(PDO::FETCH_ASSOC);

                        echo '<img class="rounded-circle" id="fotoProfilHor" src="administrator/img/profil/' . $gambarProfil['gambar_profil'] . '?dummy=' . filemtime(dirname(__FILE__) . '/../administrator/img/profil/' . $gambarProfil['gambar_profil']) . '"/>';
                    } else {
                        echo 'Login';
                    }
                    ?></button>
                </li>
            </ul>
        </div>
    </div>
    <div class="w-100 d-flex align-items-stretch d-lg-none flex-column">
        <button id="toggleMenuBtn" class="w-100 bg-grey-1 header-drop-btn"><span id="toggleIconHeader"
                class="icon-down-open"></span></button>
        <div id="menuContVer" class="bg-grey-1" style="display: none;">
            <ul class="header-list d-flex justify-content-end px-2 w-100 align-items-stretch flex-column bg-grey-1">
                <li>
                    <button class="p-2 pesanMenuBtn">Pesan Menu</button>
                </li>
                <li>
                    <button class="p-2 pesanTempatBtn">Pesan Tempat</button>
                </li>
                <li>
                    <button class="p-2 aboutUsBtn">Tentang Kami</button>
                </li>
                <li>
                    <button class="p-2 calllUsBtn">Hubungi Kami</button>
                </li>
                <li>
                    <button class="p-2 d-flex align-items-center <?php
                    if (isset($_SESSION['userID'])) {
                        echo 'profilBtn';
                    } else {
                        echo 'loginBtn';
                    }
                    ?>">
                        <?php
                        if (isset($_SESSION['userID'])) {
                            $stmt = $db->prepare('SELECT gambar_profil FROM account_tb WHERE SHA2(email, 256)=:email');
                            $stmt->bindParam(':email', $_SESSION['userID']);
                            $stmt->execute();

                            $gambarProfil = $stmt->fetch(PDO::FETCH_ASSOC);

                            echo 'Profil&nbsp;<img class="rounded-circle foto-profil-btn-ver" id="fotoProfilVer" src="administrator/img/profil/' . $gambarProfil['gambar_profil'] . '?dummy=' . filemtime(dirname(__FILE__) . '/../administrator/img/profil/' . $gambarProfil['gambar_profil']) . '"/>';
                        } else {
                            echo 'Login';
                        }
                        ?>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>