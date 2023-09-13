<?php
if (isset($_SESSION['user_id'])) {
    # code...
    $dataQuery = "SELECT * FROM urls WHERE owner_id = ? ";
    if ($_SESSION['isAdmin'] == 1) {
        $allUrls = $conn->query('SELECT * FROM urls');
        $usersData = $conn->query('SELECT * FROM users');
    }
    $dataStmt = $conn->prepare($dataQuery);
    $user_idForData = $conn->real_escape_string($_SESSION['user_id']);
    $dataStmt->bind_param("s", $user_idForData);
    $dataStmt->execute();
    $userUrls = $dataStmt->get_result();
    $dataStmt->close();

    $clickCount = 0;
    foreach ($userUrls as $key => $link) {
        $clickCount += $link['click'];
    }
}
?>