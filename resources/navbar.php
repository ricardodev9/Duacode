<?php
 $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/prueba_tecnica_duacode/Duacode";
?>
<link rel="stylesheet" href="assets/css/navbar.css">
<nav class="navbar">
    <div class="navbar-container container">
        <h1 class="logo"><a href="<?=$baseUrl?>/index.php">Duacode</a></h1>
    </div>
</nav>