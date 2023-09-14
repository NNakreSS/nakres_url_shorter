<?php
session_start();
ob_start();
$currentDomain = $_SERVER["HTTP_REFERER"];
include_once './config.php';
include_once './service/_connect.php';
include_once './service/_URLrewrite.php';
include_once './service/_getData.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>URL SHORTER</title>
    <style>
        <?php
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] != 1) {
            ?>
            main {
                width: 75%;
                margin: auto;
                display: grid;
                gap: 20px;
                grid-template-columns: 1fr 1fr;
                grid-template-areas:
                    "total total"
                    "url-form url-form"
                    "links links "
                    "links links";
                padding: 20px 0px;
            }

            <?php
        }
        ?>
    </style>
</head>

<body>
    <?php
    include_once('partials/_alert-confirm.php');
    if (isset($_SESSION["user_id"])) {
        include_once('partials/_main.php');
    } else {
        include_once('partials/_login.php');
    }
    ?>
    <?php include_once('partials/_footer.php') ?>
    <script src="script.js"></script>
</body>

</html>

<?php
ob_end_flush();
?>