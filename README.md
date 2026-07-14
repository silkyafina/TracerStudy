# Tracer Studi Universitas Harkat

Sistem **Tracer Studi Universitas Harkat** merupakan aplikasi berbasis web yang digunakan untuk melakukan pendataan dan pelacakan alumni. Aplikasi ini membantu universitas dalam memperoleh informasi mengenai kondisi lulusan setelah menyelesaikan pendidikan, seperti status pekerjaan, studi lanjut, kesesuaian bidang pekerjaan, serta berbagai indikator lainnya yang dibutuhkan untuk akreditasi maupun evaluasi mutu pendidikan.

---

## Teknologi

Aplikasi ini dibangun menggunakan teknologi berikut:

| Komponen   | Versi                             |
| ---------- | --------------------------------- |
| PHP        | 8.4                               |
| Laravel    | Versi Terbaru                     |
| Database   | MySQL 8+                          |
| Web Server | OpenLiteSpeed                     |
| Composer   | 2.x                               |
| Node.js    | 22+ (Opsional, untuk build asset) |

---

## Persyaratan Sistem

Pastikan server telah terinstall:

- PHP 8.4
- Composer
- MySQL 8.x
- OpenLiteSpeed
- Git
- Ekstensi PHP:
    - BCMath
    - Ctype
    - cURL
    - DOM
    - Fileinfo
    - JSON
    - Mbstring
    - OpenSSL
    - PDO
    - Tokenizer
    - XML
    - Zip

---

# Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/phbdev/tracer-studi.git

cd tracer-studi
```

## 2. Install Dependency

```bash
composer install
```

## 3. Copy Environment

```bash
cp .env.example .env
```

## 4. Konfigurasi Database

Edit file `.env`

```env
APP_NAME="Tracer Studi Universitas Harkat"

APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tracer_studi
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 6. Jalankan Migration

```bash
php artisan migrate
```

Jika tersedia seeder:

```bash
php artisan migrate --seed
```

---

## 7. Storage Link

```bash
php artisan storage:link
```

---

## 8. Build Asset (Opsional)

```bash
npm install
npm run build
```

---

# Menjalankan Aplikasi

Untuk development:

```bash
php artisan serve
```

Aplikasi akan berjalan di

```
http://127.0.0.1:8000
```

---

# Deployment Production

Optimasi aplikasi:

```bash
composer install --no-dev --optimize-autoloader

php artisan optimize

php artisan config:cache

php artisan route:cache

php artisan view:cache
```

Pastikan folder berikut memiliki permission yang sesuai:

```
storage/
bootstrap/cache/
```

---
