<?php
// Bağlantı oluşturma
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>