<?php
if ($_SESSION['isAdmin'] == 1) {
    include_once('_user-controll.php');
    include_once('_users.php');
    include_once('_all-links.php');
} else {
    echo "Bu sayfa için yetkin yok ! ";
}
?>