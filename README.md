<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<h2 id="dokumentasi">Dokumentasi API</h2>

- API Login
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/login.PNG)

- API Logout
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/logout.PNG)

- API Create User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createUser.PNG)

- API Read User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readUser.PNG)

- API Update User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/updateUser.PNG)

- API Delete User
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deleteUser.PNG)

- API Create Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createRole.PNG)

- API Create User Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createUserRole.PNG)

- API Read User Role
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readUserRole.PNG)

- API Create Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/createPosts.PNG)

- API Read Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/readPosts.PNG)

- API Update Posts
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/updatePosts.PNG)

- API Delete Posts (Bukan user yang membuat posts tersebut)
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deletePosts1.PNG)

- API Delete Posts (User yang membuat posts tersebut)
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/deletePosts2.PNG)

- API Upload Foto
![](https://github.com/fauzanmuh/Test-BMTMedia/raw/master/dokumentasiAPI/uploadFoto.PNG)

<h2 id="install">Panduan Menjalankan & Install Aplikasi</h2>

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
