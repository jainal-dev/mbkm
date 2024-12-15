<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRPL 117-3</title>

    <!--========= style =========-->
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script> <!-- Menambahkan script.js -->
</head>
<body>
    <div class="container">
        <div class="navbar">
            <ul>
                <li>
                    <a href="">
                        <span class="logo"><img src="polibatam-white.png" width="40px" alt=""></span>
                        <span class="tim">Project Base Learning TRPL 117-3</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="loadData">
                        <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
                        <span class="title">Load Data</span>
                    </a>
                </li>
                <li>
                    <a href="formulir.php">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <a href="formulir.php"></a>
                        <span class="title" >Pengajuan MBKM</span>
                    </a>
                </li>
            </ul>
        </div>

        <!--main content-->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <img src="prof.jpg" class="user" onclick="menu()">
            </div>

            <div id="content">
                <p>Welcome to the SPA!</p>
            </div>
        </div>

        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <a href="session_destroy.php" class="link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <p>Logout</p>
                </a>
                <a href="" class="link">
                    <ion-icon name="card-outline"></ion-icon>
                    <p>Edit Profile</p>
                </a>
            </div>
        </div>
    </div>
    <!-- ======== script ======== -->
    <script src="main.js"></script>
    
    <!-- ======== ionicons ======== -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>