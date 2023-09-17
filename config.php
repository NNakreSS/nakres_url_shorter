<?php
$config = [];
// mysql
$config['servername'] = "localhost"; // MySQL sunucu adı
$config['username'] = "root"; // MySQL kullanıcı adı
$config['password'] = ""; // MySQL parola
$config['dbname'] = "url_shorter"; // Veritabanı adı

// Dont Touch
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
    $config['domain'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
} elseif (isset($_SERVER["HTTP_REFERER"])) {
    $config['domain'] = $_SERVER["HTTP_REFERER"];
} else {
    $config['domain'] = "http://localhost/nakres_url_shorter/";
}
$config['index_location'] = './';

// html
$config['title'] = "NakreS - Url Shorter";
$config['logo'] = "NakreS LİNK";
?>