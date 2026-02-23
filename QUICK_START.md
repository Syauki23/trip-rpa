# Trip System - Quick Start Guide

## 🚀 Get Started in 5 Minutes

### Step 1: Configure Environment
```bash
copy .env.example .env
```

Edit `.env` and set your database:
```
DB_DATABASE=trip_system
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2: Generate Key
```bash
php artisan key:generate
```

### Step 3: Setup Database
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### Step 4: Start Server
```bash
php artisan serve
```

### Step 5: Login
Visit: http://localhost:8000

**Test Accounts:**
- Admin: `admin@pt.com` / `12345678`
- Supervisor: `supervisor@pt.com` / `12345678`
- Driver: `driver@pt.com` / `12345678`

---

## 📋 Quick Test Workflow

### As Admin:
1. Login as admin@pt.com
2. Go to "Vehicles"
3. Add a new vehicle (e.g., Toyota Avanza, B 1234 XYZ, Available)

### As Driver:
1. Logout and login as driver@pt.com
2. Click "New Trip"
3. Fill form:
   - Select vehicle
   - Enter destination
   - Enter purpose
   - Enter starting KM
   - Select departure time
   - Upload starting photo
4. Submit → Trip status: **pending**

### As Supervisor:
1. Logout and login as supervisor@pt.com
2. View the pending trip
3. Click "Approve Trip"
4. Trip status: **approved**

### As Driver (Continue):
1. Login as driver@pt.com
2. View your trip
3. Click "Start Trip"
4. Trip status: **ongoing**
5. Click "Finish Trip"
6. Fill form:
   - Enter ending KM
   - Select return time
   - Upload ending photo
7. Submit → Trip status: **completed**

### As Supervisor (Final):
1. Login as supervisor@pt.com
2. View the completed trip
3. Click "Verify Trip"
4. Trip status: **verified** ✅

---

## 🎯 Key Features

### Admin Dashboard
- ✅ Full vehicle CRUD
- ✅ View all trips
- ✅ Monitor system activity

### Supervisor Dashboard
- ✅ Approve pending trips
- ✅ Verify completed trips
- ✅ View all trip details

### Driver Dashboard
- ✅ Create new trips
- ✅ Start approved trips
- ✅ Finish ongoing trips
- ✅ Upload photos
- ✅ Track trip history

---

## 📊 Trip Status Flow

```
┌─────────┐    ┌──────────┐    ┌─────────┐    ┌───────────┐    ┌──────────┐
│ pending │ -> │ approved │ -> │ ongoing │ -> │ completed │ -> │ verified │
└─────────┘    └──────────┘    └─────────┘    └───────────┘    └──────────┘
   Driver      Supervisor       Driver          Driver         Supervisor
```

---

## 🔧 Troubleshooting

### Images not showing?
```bash
php artisan storage:link
```

### Database errors?
Check `.env` database credentials and ensure MySQL is running.

### Permission errors?
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📁 Project Structure

```
trip-rpa/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Admin/VehicleController.php
│   │   │   ├── Admin/TripController.php
│   │   │   ├── Supervisor/TripController.php
│   │   │   └── Driver/TripController.php
│   │   └── Middleware/RoleMiddleware.php
│   └── Models/
│       ├── Role.php
│       ├── User.php
│       ├── Vehicle.php
│       └── Trip.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── auth/login.blade.php
│   ├── admin/
│   ├── supervisor/
│   ├── driver/
│   └── partials/
└── routes/web.php
```

---

## 🎨 UI Features

- Bootstrap 5.3 styling
- Bootstrap Icons
- Responsive design
- Image preview on upload
- Alert notifications
- Pagination
- Confirmation dialogs

---

## 🔒 Security

- CSRF protection
- Role-based access control
- Password hashing
- File upload validation
- Input sanitization

---

## 📝 Notes

- All images stored in `storage/app/public/trips`
- Pagination: 10 items per page
- Image max size: 2MB
- Supported formats: JPEG, PNG, JPG

---

## ✅ System Ready!

Your Trip System is now fully configured and ready to use. Enjoy! 🚗💨
