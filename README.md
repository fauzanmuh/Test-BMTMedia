<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Dokumentasi API

- API Login
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/login.png)

- API Logout
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/logout.png)

- API Create User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createUser.png)

- API Read User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readUser.png)

- API Update User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/updateUser.png)

- API Delete User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deleteUser.png)

- API Create Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createRole.png)

- API Create User Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createUserRole.png)

- API Read User Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readUserRole.png)

- API Create Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createPosts.png)

- API Read Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readPosts.png)

- API Update Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/updatePosts.png)

- API Delete Posts (Bukan user yang membuat posts tersebut)
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deletePosts1.png)

- API Delete Posts (User yang membuat posts tersebut)
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deletePosts2.png)

- API Upload Foto
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/uploadFoto.png)

## Panduan Menjalankan & Install Aplikasi

Buat Database

Clone project 

``` $ git clone https://github.com/fauzanmuh/Test-BMTMedia.git ```

Buka Kode editor → Terminal.
  
Masukkan perintah di bawah ini satu per satu (Tanpa $),
  ```
  $ composer update
  $ composer install
  $ cp .env.example .env
  $ php artisan key:generate
  ```
  
Edit the .env file like this,
  ```
  DB_CONNECTION = mysql
  DB_HOST = 127.0.0.1 // change to Host your database
  DB_PORT = 3306
  DB_DATABASE = terserah // change to the name of the database table that you created
  DB_USERNAME = root // change to be your database username, default root
  DB_PASSWORD =    // change to your databse password, null default 
  ```

Migrate database:
  ```$ php artisan migrate```
  
Done 😉, untuk menjalankannya:
  ```$ php artisan serve```

Menjalankan Unit Testing
``` $ php artisan test```
  
Thank you 😁
