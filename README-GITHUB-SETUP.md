# GitHub setup

File yang harus dibuat lokal tetapi tidak boleh di-push:
- `.env`
- `storage/app/firebase/service-account.json`

Setelah clone:

1. `composer install`
2. `copy .env.example .env` (Windows) atau `cp .env.example .env` (Linux/macOS)
3. `php artisan key:generate`
4. Salin `service-account.json` ke `storage/app/firebase/service-account.json`
5. `php artisan optimize:clear`
6. `php artisan serve`

Jangan gunakan `git add -f` untuk memaksa file rahasia masuk repository.
