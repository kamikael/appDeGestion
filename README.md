# Projet App (Laravel 12 + Angular 20)

## Lancer en local
### Backend (Laravel)
cd backend
cp .env.example .env
# Configurer DB dans .env
composer install
php artisan key:generate
php artisan serve

### Frontend (Angular)
cd ../frontend
npm install
ng serve
