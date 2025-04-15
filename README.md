## Requirements
- PHP >= 7.4
- Composer
- Laravel 10+
- MySQL / SQLite

## Setup
```bash
git clone https://github.com/somesh2275/bookingapi.git
cd bookingapi
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Run Tests
```bash
php artisan test
```

## API Endpoints
- `GET /api/events`
- `POST /api/events`
- `GET /api/events/{id}`
- `PUT /api/events/{id}`
- `DELETE /api/events/{id}`
- `POST /api/attendees`
- `PUT /api/attendees/{id}`
- `DELETE /api/attendees/{id}`
- `POST /api/bookings`
- `DELETE /api/bookings/{id}`