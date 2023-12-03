<h1 align="center">Backend CBT</h1>

## Prerequisites

- Pastikan versi PHP ^8.1.
- Composer dan MySQL sudah terinstall.

## Guide

- Copy file .env.example ke .env

```bash
cp .env.example .env
```

- Sesuaikan isi file .env dengan kredensial database local anda.


```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbtdb
DB_USERNAME=root
DB_PASSWORD=
```

- Jalankan command composer install.

```bash
composer install
```

- Buat key baru.

```bash
php artisan key:generate
```

- Migrate ke database anda (sekaligus memasukkan seed).

```bash
php artisan migrate:fresh --seed
```

- Generate API Documentation untuk referensi penggunaan API (berguna untuk Mobile Developer)

```bash
php artisan scribe:generate
```

- Jalankan aplikasi.

```bash
php artisan serve
```

- Buka browser dan ketikkan url.

```
http://localhost:8000
```

- Kredensial untuk login yaitu:

```
ADMIN:
Username     = admin@admin.com
Password    = 12345678

```
