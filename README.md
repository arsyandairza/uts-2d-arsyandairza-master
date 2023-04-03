[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-8d59dc4de5201274e310e4c54b9627a8934c3b88527886e3b421487c677d23eb.svg)](https://classroom.github.com/a/N3vMaoU-)
## Soal UTS Laravel

1. Fork Repository ini ke repository anda sendiri
2. Clone repository yang sudah anda fork ke local
3. Lakukan Setup Laravel untuk lokal development anda
4. Composer install
5. Copy .env.example ke .env
6. Buat 2 database, beri nama laravel_uts_development dan laravel_uts_testing
7. Sesuaikan konfigurasi database anda untuk development di .env
8. Sesuaikan konfigurasi database anda utnuk testing di .evn.testing
9. Lakukan php artisan migrate fresh --seed
10. Di project ini sudah dibuatkan beberapa file untuk membuat CRUD pada table mahasiswa.
11. Perbaikilah codingan ini agar bisa berjalan.
12. File yang harus anda perbaiki adalah
    - app/Http/Controllers/MahasiswaController.php
    - app/Http/Requests/CreateMahasiswaRequest.php
    - app/Http/Requests/UpdateMahasiswaRequest.php
    - app/Mahasiswa.php
    - database/migrations/2019_11_01_000000_create_mahasiswas_table.php
    - database/seeds/MahasiswaSeeder.php
    - resources/views/mahasiswa/index.blade.php
    - resources/views/mahasiswa/create.blade.php
    - resources/views/mahasiswa/edit.blade.php
    - resources/views/mahasiswa/show.blade.php
13. Bersama project ini sudah ada test code yang menyertainya silahkan fixing test code ini sampai lolos semua kemudian lakukan pull request.
