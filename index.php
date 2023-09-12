<?php
session_start();
ob_start();
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
</head>

<body>
    <div class="overlay" id="overlay"></div>
    <div class="custom-confirm" id="custom-confirm">
        <p>Yapmak istediniz işlemi onaylıyor musunuz ?</p>
        <button id="confirm-yes">Evet</button>
        <button id="confirm-no">Hayır</button>
    </div>

    <div class="alert-box"></div>
    <?php
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