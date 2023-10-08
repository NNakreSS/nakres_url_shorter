![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/68d3f84a-225f-474a-a8f0-2c8eee5655f8)

![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/1230657f-f6c1-440c-9354-744b95add3e8)

![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/74616f85-2873-4de7-886a-1bc039200cc3)

![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/a399130d-45c2-4427-83b8-2524473e5aad)

![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/bbf67005-b4e5-4fb7-97d1-5699449ff1cb)

![image](https://github.com/NNakreSS/nakres_url_shorter/assets/87872407/a76a7344-0b88-4ecb-b475-73dd261d0ab4)


# TR:

*DEMO* : https://link.nakres.dev/
- Kullanıcı: user
- Şifre: user123
## Proje Tanıtımı

Bu proje, URL'leri kısaltabilen ve kısaltılan URL'leri yönetebilen bir PHP uygulamasını içerir. Ayrıca, bir üyelik sistemi ve yönetici paneli içerir.

## Özellikler

- **Admin Paneli:**
  - Yönetici kullanıcıları, üye oluşturma, üye yönetme, tüm linkleri silme gibi yetkilere sahiptir.
- **Üye Paneli:**
  - Üyeler kendi linklerini düzenleme, yeni linkler ekleme ve kendi linklerini silme yetkisine sahiptir.
- **Link Kısaltma:**
  - URL'leri kısaltma ve projeye bağlı domain üzerinden yönlendirme yapma.Kısaltılmış linklere tıklanma sayısını görüntüleme.
- **Güvenlik:**
  - Proje, güvenlik önlemleri ile korunur ve kullanıcı girişleri güvenli bir şekilde yönetilir.
  
## Başlangıç

- Bu Projee LOCALHOST / HOSTİNG / VDS /  VPS üzerinde Apache veya ISS ile kolayca çalıştırılabilecek şekilde tasarlamştır. Proje dosyalarını yayınlayacağınız dizine çıkartın ve gerekli ayarları yaparak kullanıma başlayın.

### Veri Tabanı Oluşturun

- ilk olarak bir veri tabanı oluşturun ve proje içerisinde sql dosyasını veritabanına import edin:
- Proje içerisinden config.php dosyasını bulun ve MySQL config ayarlarını doldurun.
````php
$config['servername'] = "localhost"; // MySQL sunucu adı
$config['username'] = "root"; // MySQL kullanıcı adı
$config['password'] = ""; // MySQL parola
$config['dbname'] = "url_shorter"; // Veritabanı adı
````
- Projeniz kullanıma hazır varsayılan admin kullnıcı adı  : **admin** | şifre : **admin123** olarak ayarlanmıştır , giriş yaptıktan sonra yeni kullanıcılar oluşturabilir ve şifre kullanıcı adlarını düzenleyebilirsiniz.

# EN:

# NakreS URL Shortener:

*DEMO*: https://link.nakres.dev/
- User: user
- Password: user123
## Project Introduction

This project includes a PHP application that can shorten URLs and manage the shortened URLs. It also features a membership system and an admin panel.

## Features

- **Admin Panel:**
  - Admin users have privileges such as creating users, managing members, and deleting all links.
- **Member Panel:**
  - Members have the authority to edit their own links, add new links, and delete their own links.
- **Link Shortening:**
  - Shorten URLs and redirect through the domain associated with the project. View the number of clicks on shortened links.
- **Security:**
  - The project is protected with security measures, and user logins are managed securely.

## Getting Started

- This project is designed to be easily run with Apache or ISS on LOCALHOST / HOSTING / VDS / VPS. Extract the project files to the directory where you will publish them and start using them by making the necessary settings.

### Create a Database

- First, create a database and import the SQL file in the project into the database:
- Find the config.php file within the project and fill in the MySQL config settings.
````php
$config['servername'] = "localhost"; // MySQL server name
$config['username'] = "root"; // MySQL username
$config['password'] = ""; // MySQL password
$config['dbname'] = "url_shorter"; // Database name
````
- Your project is ready to use. The default admin username is set to **admin** | password: **admin123**, after logging in, you can create new users and edit password usernames.
