<?php
session_start();
require_once '_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'login':
            echo checkLogin($_POST['username'], $_POST['password'], $conn);
            break;
        case 'logout':
            echo logOut();
            break;
        case 'add_new_user':
            echo addNewUserToDatabase($_POST['username'], $_POST['password'], $_POST['isAdmin'], $conn);
            break;
        case 'add_new_url':
            echo addUrlToDatabase($_POST['full_url'], $_POST['short_tag']);
            break;
        default:
            break;
    }
} else {
    echo '<h1>Bu sayfayı Görüntülemek için yetkiniz yok !</h1>';
    header("Refresh:3 ; url=../index");
}

function checkLogin($username, $password, $conn)
{
    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM user WHERE user_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['user_password'];
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['isAdmin'] = $row['isAdmin'];
                $message = "Parola doğrulandı, kullanıcı girişi başarılı";
                $type = "success";
            } else {
                $message = "Parola doğrulanamadı, kullanıcı girişi başarısız";
                $type = "error";
            }
        } else {
            $message = "Kullanıcı adı bulunamadı";
            $type = "error";
        }
        $stmt->close();
    }
    return json_encode(["message" => $message, "type" => $type]);
}

function logOut()
{
    if ($_SESSION['user_id']) {
        session_destroy();
        return json_encode(["message" => "Başarıyla çıkış yapıldı", "type" => "success"]);
    }
}

function addNewUserToDatabase($username, $password, $isAdmin, $conn)
{

}

function addUrlToDatabase($url, $tag)
{

}

function generateRandomUserID($length = 8)
{
    return bin2hex(random_bytes($length));
}
?>