<!-- <div id="light-left-top"></div>
<div id="light-right-center"></div>
<div id="light-center-bottom"></div> -->
<?php include_once('partials/_header.php'); ?>
<main>
    <?php include_once('partials/_total-info.php') ?>
    <?php include_once('partials/_url-form.php') ?>
    <?php include_once('partials/_links.php') ?>
    <!-- only is admin -->
    <?php
    if ($_SESSION['isAdmin'] == 1)
        include_once('partials/_admin.php');
    ?>
</main>