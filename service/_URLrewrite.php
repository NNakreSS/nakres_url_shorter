<?php
if (isset($_GET) && !empty($_GET)) {
    $keys = array_keys($_GET);
    $short_url = str_replace('/', '', $keys[0]);
    if (preg_match('/^[a-zA-Z0-9]+$/', $short_url)) {
        $query = "SELECT long_url FROM urls WHERE short_url = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $short_url);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($long_url);
            $stmt->fetch();
            $stmt->close();
            $query = "UPDATE urls SET click = click + 1 WHERE short_url = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $short_url);
            $stmt->execute();
            $stmt->close();
            // Orijinal URL'ye yönlendir
            header("Location: " . $long_url);
            exit();
        } else {
            header("Location:" . $config['index_location']);
            exit();
        }
    } else {
        header("Location:" . $config['index_location']);
        exit();
    }
}
?>