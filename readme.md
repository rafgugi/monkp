## Monitoring Kerja Praktik

### Cara menginstal (windows)
 - Install requirement: [xampp](https://www.apachefriends.org/download.html)(web server, PHP >= 5.4, mysql), [composer](https://getcomposer.org/download).
 - Ubah settings apache `php.ini`, hapus `;` pada `extension=php_fileinfo.dll`
 - Buat folder `monkp` di direktori public xampp. Biasanya di `C:\xampp\htdocs`.
 - Download source ini dan masukkan ke dalam folder `monkp`.
 - Buka command line, jalankan `composer-update` di direktori utama `monkp`.
 - Selagi menunggu update selesai, [buat database baru di mysql](http://www.slideshare.net/prin000/step-by-step-how-to-create-database-with-phpmyadmin), beri nama `monkp`.
 - Rename `./.env.example` menjadi `.env`.
 - Setelah update selesai, jalankan `composer dump-autoload`.
 - Jalankan `php artisan migrate` untuk membuat seluruh tabel.
 - Jalankan `php artisan db:seed` untuk menginisialisasi record.
 - Buka `localhost/monkp` lewat browser.

### Cara menginstal (linux)
 - Baca cara menginstal (windows).
 - Instal sendiri setau anda. Cari di google bila perlu.
 - Bantuan:
   - White blank page: `sudo chmod -R o+w storage/`
   - Encrypt error: `sudo php5enmod mcrypt; sudo apache2 restart`

### Abis install
 - Setting app
   - Buka `localhost/monkp`
   - login dengan user `koorkp` dan password `koorkp`
   - klik Periode di sidebar
   - konfigurasi semester aktif

### Proxified git (git bash)
   ``git config --global http.proxy http://proxyuser:proxypwd@proxy.server.com:8080``  
   ``git config --global https.proxy https://proxyuser:proxypwd@proxy.server.com:8080``  
   ``git config --global --unset http.proxy``  
   ``git config --global --unset https.proxy``  

### Git without aunthetication
`git config remote.origin.url "https://{username}:{password}@github.com/{username}/{project}.git"`
