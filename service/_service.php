<?php
session_start();
require_once '../config.php';
require_once '_connect.php';
date_default_timezone_set('Europe/Istanbul');

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
        case 'delete_user':
            echo deleteUserToDatabase($_POST['username'], $conn);
            break;
        case 'update_user':
            echo updateUserToDatabase($_POST['username'], $_POST['new_user_name'], $_POST['new_passowrd'], $_POST['isAdmin'], $conn);
            break;
        case 'add_new_url':
            echo addUrlToDatabase($_POST['full_url'], $_POST['short_tag'], $conn);
            break;
        case 'delete_url':
            echo deleteUrlToDatabase($_POST['url'], $conn);
            break;
        case 'edit_url':
            echo updateUrlToDatabase($_POST['short_url'], $_POST['new_short_url'], $_POST['long_url'], $conn);
            break;
        default:
            break;
    }
}

function checkLogin($username, $password, $conn)
{
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    // return json_encode(["message" => !empty($username)." : ".!empty($password), "type" => "info"]);
    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE BINARY user_name = ?";
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
    }else {
        $message = "Kullanıcı adı alınamadı " ;
        $type = "error";
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
    if ($_SESSION['isAdmin'] == 1 && (!empty($username) && !empty($password))) {
        $username = $conn->real_escape_string($username);
        if (isDoesExistUser($username, $conn)) {
            $message = "Bu kullanıcı adı zaten kullanılıyor ! ";
            $type = "error";
        } else {
            $password = $conn->real_escape_string($password);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = generateRandomUserID(6, $conn);
            if ($isAdmin == "true") {
                $isAdmin = 1;
            } else {
                $isAdmin = 0;
            }
            $query = "INSERT INTO users (user_name,user_password,isAdmin,user_id) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssis", $username, $password, $isAdmin, $user_id);
            $insertResult = $stmt->execute();
            $stmt->close();
            if ($insertResult) {
                $message = "Yeni kullanıcı başarıyla eklendi ";
                $type = "success";
            } else {
                $message = "Kullanıcı eklenirken bir hata meydana geldi ! ";
                $type = "error";
            }
        }
        return json_encode(["message" => $message, "type" => $type]);
    } else {
        echo "Bunun için yetkin yok ! ";
    }
}

function deleteUserToDatabase($username, $conn)
{
    if ($_SESSION['isAdmin'] == 1) {
        if ((!empty($username))) {
            $username = $conn->real_escape_string($username);
            if (isDoesExistUser($username, $conn)) {
                $query = "DELETE FROM users WHERE user_name = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $username);
                $delete = $stmt->execute();
                $stmt->close();
                if ($delete) {
                    $message = "Kullanıcı başarıyla silindi";
                    $type = "success";
                } else {
                    $message = "Kullanıcı silinirken bir hata meydana geldi";
                    $type = "error";
                }
            } else {
                $message = "Kullanıcı bulunamadı ! ";
                $type = "error";
            }
        } else {
            $message = "username değeri tanımsız ! ";
            $type = "error";
        }
        return json_encode(["message" => $message, "type" => $type]);
    } else {
        echo "Bunun için yetkin yok ! ";
    }
}

function updateUserToDatabase($username, $new_user_name, $new_password, $isAdmin, $conn)
{
    if ($_SESSION['isAdmin'] == 1) {
        if ((!empty($username))) {
            $username = $conn->real_escape_string($username);
            $new_user_name = $conn->real_escape_string($new_user_name);
            $new_password = $conn->real_escape_string($new_password);
            if ($isAdmin == "true") {
                $isAdmin = 1;
            } else {
                $isAdmin = 0;
            }
            if (isDoesExistUser($username, $conn)) {
                $query = "UPDATE users SET user_name = ?, isAdmin = ? WHERE user_name = ?";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("sis", $new_user_name, $isAdmin, $username);
                $result = $stmt->execute();
                $stmt->close();
                if ($new_password != "") {
                    $password = password_hash($new_password, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET user_password = ? WHERE user_name = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ss", $password, $username);
                    $result = $stmt->execute();
                    $stmt->close();
                    if (!$result) {
                        $message = "Düzenleme sırasında bir hata meydana geldi  ! ";
                        $type = "error";
                        return json_encode(["message" => $message, "type" => $type]);
                    }
                }
                if ($result) {
                    $message = "Düzenleme başarılı";
                    $type = "success";
                } else {
                    $message = "Düzenleme sırasında bir hata meydana geldi  ! ";
                    $type = "error";
                }
            } else {
                $message = "Kullanıcı bulunamadı ! ";
                $type = "error";
            }
        } else {
            $message = "username değeri tanımsız ! ";
            $type = "error";
        }
        return json_encode(["message" => $message, "type" => $type]);
    } else {
        echo "Bunun için yetkin yok ! ";
    }
}

function addUrlToDatabase($url, $tag, $conn)
{
    $long_url = $conn->real_escape_string($url);
    if (!empty($long_url) && filter_var($long_url, FILTER_VALIDATE_URL)) {
        if ($tag != "" && $tag != "null") {
            if (!isDoesExistShortUrl($tag, $conn)) {
                $short_url = $conn->real_escape_string($tag);
            } else {
                $message = $tag . " - " . " tagı zaten kullanılıyor ! ";
                $type = "error";
                return json_encode(["message" => $message, "type" => $type]);
            }
        } else {
            $short_url = getRandomShortUrl($conn);
        }
        $create_date = date("Y-m-d H:i:s");
        $owner_id = $_SESSION['user_id'];
        $owner_name = $_SESSION['user_name'];
        $click = 0;
        $query = "INSERT INTO urls (long_url, short_url, click , owner_id , owner_name, create_date) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssisss', $long_url, $short_url, $click, $owner_id, $owner_name, $create_date);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            $message = "Link başarıyla kısaltıldı ! ";
            $type = "success";
        } else {
            $message = "Linkiniz kısaltılırken bir hata meydana geldi ! ";
            $type = "error";
        }
    } else {
        $message = "Geçerli bir url adresi girin ! ";
        $type = "error";
    }
    return json_encode(["message" => $message, "type" => $type]);
}

function deleteUrlToDatabase($url, $conn)
{
    $short_url = $conn->real_escape_string($url);
    if (!empty($short_url) && $short_url != "") {
        if (isDoesExistShortUrl($short_url, $conn)) {
            $query = "DELETE FROM urls WHERE short_url = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $short_url);
            $deleted = $stmt->execute();
            $stmt->close();
            if ($deleted) {
                $message = "$short_url - Link silindi ! ";
                $type = "success";
            } else {
                $message = "Silinemedi ! ";
                $type = "error";
            }
            return json_encode(["message" => $message, "type" => $type]);
        } else {
            $message = "Url bulunamadı ! ";
            $type = "error";
            return json_encode(["message" => $message, "type" => $type]);
        }
    } else {
        $message = "data-tag değerine erişilemedi ! ";
        $type = "error";
    }
    return json_encode(["message" => $message, "type" => $type]);
}

function updateUrlToDatabase($short_url, $new_short_url, $long_url, $conn)
{
    $short_url = $conn->real_escape_string($short_url);
    $new_short_url = $conn->real_escape_string($new_short_url);
    $new_url = $conn->real_escape_string($long_url);
    if (!empty($short_url) && $short_url != "") {
        if (isDoesExistShortUrl($short_url, $conn)) {
            if ($short_url != $new_short_url && isDoesExistShortUrl($new_url, $conn)) {
                $message = $new_url . " - Zaten kullanılıyor başka bir takma ad seçin ! ";
                $type = "error";
            } else {
                $query = "UPDATE urls SET short_url = ?  , long_url = ? WHERE short_url  = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sss', $new_short_url, $new_url, $short_url);
                $update = $stmt->execute();
                $stmt->close();
                if ($update) {
                    $message = "Değişiklikler kaydedildi";
                    $type = "success";
                } else {
                    $message = "Güncelleme sırasında bir hata meydana geldi ! ";
                    $type = "error";
                }
            }
        } else {
            $message = "Url bulunamadı ! ";
            $type = "error";
            return json_encode(["message" => $message, "type" => $type]);
        }
    } else {
        $message = "data-tag değerine erişilemedi ! ";
        $type = "error";
    }
    return json_encode(["message" => $message, "type" => $type]);
}

function isDoesExistUser($username, $conn)
{
    $query = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0) {
        return true;
    } else
        return false;
}

function isDoesExistShortUrl($url, $conn)
{
    $short_url = $conn->real_escape_string($url);
    $query = "SELECT * FROM urls WHERE short_url = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $short_url);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0) {
        return true;
    } else
        return false;
}

function getRandomShortUrl($conn)
{
    $tag = substr(md5(microtime()), rand(0, 26), 5);
    if (isDoesExistShortUrl($tag, $conn)) {
        return getRandomShortUrl($conn);
    }
    return $tag;
}

function generateRandomUserID($length = 6, $conn)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }

    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $randomString);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        return generateRandomUserID($length, $conn);
    } else {
        return $randomString;
    }
}


?>
