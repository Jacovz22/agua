<?php
session_start();
if (isset($_SESSION['sesion'])) {
    include "../global/Header.php";
?>
    <title>Home</title>
    <?php
    include "../global/menu.php";
    ?>

    <?php include "../global/Fooder.php"; ?>
    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>