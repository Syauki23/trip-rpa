# Trip System - Setup Instructions

## Laravel 10 Trip Management System

This is a complete trip management system with role-based access control for Admin, Supervisor, and Driver roles.

---

## Installation Steps

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Configuration
Copy the `.env.example` to `.env` and configure your database:
```bash
copy .env.example .env
```

Edit `.env` file and set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_system
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed Database
```bash
php artisan db:seed
```

This will create:
- 3 roles: admin, supervisor, driver
- 3 default users:
  - admin@pt.com (password: 12345678)
  - supervisor@pt.com (password: 12345678)
  - driver@pt.com (password: 12345678)

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Start Development Server
```bash
php artisan serve
```

The application will be available at: http://localhost:8000

---

## Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pt.com | 12345678 |
| Supervisor | supervisor@pt.com | 12345678 |
| Driver | driver@pt.com | 12345678 |

---

## Features by Role

### Admin
- Manage vehicles (CRUD operations)
- View all trips
- View trip details

### Supervisor
- View all trips
- Approve pending trips
- Verify completed trips

### Driver
- Create new trips
- View own trips
- Start approved trips
- Finish ongoing trips
- Upload photos for trip start and end

---

## Trip Status Flow

```
pending → approved → ongoing → completed → verified
```

1. **pending**: Driver creates trip, waiting for supervisor approval
2. **approved**: Supervisor approves trip, driver can start
3. **ongoing**: Driver starts trip, vehicle marked as in use
4. **completed**: Driver finishes trip with ending photo and odometer
5. **verified**: Supervisor verifies completed trip

---

## Database Structure

### Tables
- `roles` - User roles (admin, supervisor, driver)
- `users` - System users with role assignment
- `vehicles` - Company vehicles with status tracking
- `trips` - Trip records with complete journey information

### Vehicle Status
- `available` - Ready for use
- `in_use` - Currently on a trip
- `maintenance` - Under maintenance

---

## Technology Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Bootstrap 5.3
- Bootstrap Icons

---

## Notes

- All images are stored in `storage/app/public/trips`
- The system uses Bootstrap 5.3 CDN for styling
- Image preview is implemented using JavaScript FileReader API
- Pagination is set to 10 items per page
- CSRF protection is enabled on all forms
- Role-based middleware protects all routes

---

## Troubleshooting

### Storage Link Issues
If images don't display, ensure the storage link is created:
```bash
php artisan storage:link
```

### Permission Issues
Ensure storage and bootstrap/cache directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

### Database Connection
Verify your database credentials in `.env` file and ensure MySQL is running.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/LoginController.php
│   │   ├── Admin/VehicleController.php
│   │   ├── Admin/TripController.php
│   │   ├── Supervisor/TripController.php
│   │   └── Driver/TripController.php
│   └── Middleware/RoleMiddleware.php
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Vehicle.php
│   └── Trip.php

database/
├── migrations/
│   ├── create_roles_table.php
│   ├── add_role_id_to_users_table.php
│   ├── create_vehicles_table.php
│   └── create_trips_table.php
└── seeders/
    ├── RoleSeeder.php
    ├── UserSeeder.php
    └── DatabaseSeeder.php

resources/views/
├── layouts/app.blade.php
├── auth/login.blade.php
├── admin/
│   ├── vehicles/
│   └── trips/
├── supervisor/trips/
├── driver/trips/
└── partials/trip-detail.blade.php

routes/web.php
```

---

## Support

For issues or questions, please refer to the Laravel documentation:
https://laravel.com/docs/10.x
