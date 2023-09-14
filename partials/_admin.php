<?php
if ($_SESSION['isAdmin'] == 1) {
    include_once('_user-controll.php');
    include_once('_users.php');
    include_once('_all-links.php');
} else {
    die ("Bu sayfa için yetkin yok ! ");
}
?>