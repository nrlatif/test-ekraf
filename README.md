# Ekraf Web Application

Aplikasi web untuk Ekonomi Kreatif yang dibangun menggunakan Laravel 12 dengan Filament Admin Panel dan TailwindCSS.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: TailwindCSS, Alpine.js
- **Admin Panel**: Filament 3.3
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Build Tool**: Vite
- **Testing**: Pest PHP

## Prerequisites

Sebelum menjalankan aplikasi, pastikan sistem Anda telah terinstal:

- PHP 8.2 atau versi lebih baru
- Composer
- Node.js (v18 atau lebih baru)
- NPM atau Yarn

## Installation & Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd ekraf-web
```

### 2. Install Dependencies

Install PHP dependencies:
```bash
composer install
```

Install Node.js dependencies:
```bash
npm install
```

### 3. Environment Configuration

Copy file environment:
```bash
# Windows (PowerShell)
Copy-Item .env.example .env

# Linux/Mac
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Database Setup

Aplikasi ini menggunakan SQLite secara default. Database akan dibuat otomatis saat menjalankan migrasi.

Jika ingin menggunakan MySQL/PostgreSQL, edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ekraf_web
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Jalankan migrasi database:
```bash
php artisan migrate
```

Jalankan seeder (opsional):
```bash
php artisan db:seed
```

### 5. Build Assets

Untuk development:
```bash
npm run dev
```

Untuk production:
```bash
npm run build
```

## Running the Application

### Development Mode

1. Start the Laravel development server:
```bash
php artisan serve
```

2. In a separate terminal, start the Vite development server:
```bash
npm run dev
```

3. Akses aplikasi di: `http://localhost:8000`

### Production Mode

1. Build assets untuk production:
```bash
npm run build
```

2. Jalankan server:
```bash
php artisan serve --env=production
```
## Features

- **Artikel Management**: Kelola artikel dengan kategori dan author
- **Banner Management**: Kelola banner website
- **Katalog Management**: Kelola katalog produk
- **User Management**: Kelola user dan level akses
- **Sub Sektor Management**: Kelola sub sektor ekonomi kreatif

## Testing

Jalankan test menggunakan Pest:

```bash
# Semua test
php artisan test

# Test spesifik
php artisan test --filter AuthenticationTest

# Test dengan coverage
php artisan test --coverage
```

## Commands Berguna

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate storage link
php artisan storage:link

# Migrasi fresh dengan seeder
php artisan migrate:fresh --seed

# Optimasi untuk production
php artisan optimize

# Queue worker (jika menggunakan queue)
php artisan queue:work
```

## Troubleshooting

### Permission Issues (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Database Issues

```bash
# Reset database
php artisan migrate:fresh

# Dengan seeder
php artisan migrate:fresh --seed
```

### Asset Issues

```bash
# Clear dan rebuild assets
npm run build
php artisan view:clear
```

## Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
