# Easy Ride - B2B Employee Cab Management System

## Project Overview

Easy Ride is a comprehensive B2B Employee Cab Management System built with Laravel. It helps IT companies manage employee transportation with features for:

- **Admin Panel** - Complete system management
- **Vendor Panel** - IT company self-service portal  
- **Driver App** - Mobile API for cab drivers

---

## System Requirements

- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+ (for frontend assets)
- Laravel 12.x

---

## Installation

### 1. Clone the Repository

```bash
cd your-project-directory
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Laravel Sanctum (for Driver API)

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 4. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=easy_ride
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed Database

This creates roles, permissions, and the default admin user.

```bash
php artisan db:seed
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Install Frontend Assets

```bash
npm install
npm run build
```

### 10. Start Development Server

```bash
php artisan serve
```

---

## Default Credentials

### Admin Login

```
URL:      http://localhost:8000/login
Email:    pavithra@gmail.com
Password: 12345678
```

---

## Project Structure

```
app/
├── Console/Commands/           # Artisan commands (alerts)
├── Enums/                      # Status enums
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Admin panel controllers
│   │   ├── Vendor/             # Vendor panel controllers
│   │   └── Api/Driver/         # Driver API controllers
│   └── Requests/               # Form request validation
├── Models/                     # Eloquent models
└── Services/                   # Business logic services

resources/
├── views/
│   ├── admin/                  # Admin panel views
│   ├── vendor/                 # Vendor panel views
│   └── layouts/                # Admin & vendor layouts

routes/
├── web.php                     # Admin & vendor web routes
└── api.php                     # Driver API routes

docs/
├── PROJECT_README.md           # This file
├── ADMIN_PANEL_README.md       # Admin panel documentation
├── VENDOR_PANEL_README.md      # Vendor panel documentation
└── DRIVER_API_README.md        # Driver API documentation
```

---

## User Roles

| Role | Access | Created By |
|------|--------|------------|
| admin | Full system access (Web) | Seeder / Admin |
| vendor | Own company data only (Web) | Admin |
| driver | Trips & earnings (API only) | Admin |

---

## Panels & Access URLs

| Panel | URL | Role Required |
|-------|-----|---------------|
| Admin Dashboard | `/admin/dashboard` | admin |
| Vendor Dashboard | `/vendor/dashboard` | vendor |
| Driver API | `/api/v1/driver/*` | driver (token) |

---

## Key Features

### Admin Panel
- Dashboard with live statistics
- Vendor management with contracts & billing settings
- Driver management with KYC & vehicle tracking
- User management with role assignment
- Route & trip management
- Billing: vendor invoices, driver payments, expenses
- Support ticket system
- Notification center
- Reports

### Vendor Panel
- Dashboard with trip overview
- Trip booking (single, weekly, special/emergency)
- Employee route management
- Invoice viewing
- Support tickets
- Notifications

### Driver API
- Token-based authentication (Sanctum)
- Today's trips listing
- Accept/Start/Complete trip workflow
- Live location tracking
- Daily & weekly earnings
- Document upload (DL, RC, Insurance)
- Vehicle info
- Support & emergency

---

## Database Tables

### Core Tables
- `users` - System users (admin, vendor, driver)
- `vendors` - IT companies
- `drivers` - Cab drivers
- `vehicles` - Driver vehicles

### Operations Tables
- `routes` - Transportation routes
- `route_points` - Pickup/drop locations
- `trips` - Individual trips

### Billing Tables
- `vendor_contracts` - Vendor contracts
- `vendor_billing_settings` - Rate configurations
- `vendor_invoices` - Monthly invoices
- `vendor_invoice_items` - Invoice line items
- `driver_payments` - Driver payouts
- `operation_expenses` - Fuel, maintenance, etc.

### Support Tables
- `support_tickets` - Help requests
- `support_messages` - Ticket conversations
- `system_notifications` - Alerts & notifications

### KYC Tables
- `driver_documents` - KYC documents
- `driver_complaints` - Complaints & ratings

---

## Scheduled Commands

Add to cron (run `crontab -e`):

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Available commands:

```bash
php artisan alerts:payment-due        # Send payment due alerts
php artisan alerts:document-expiry    # Send document expiry alerts
php artisan alerts:pickup-reminder    # Send pickup reminders
```

---

## Development Notes

### Validation
All forms use FormRequest classes in `app/Http/Requests/`.

### Enums
Status values use Laravel native enums in `app/Enums/`:
- `TripStatus` - pending, approved, assigned, accepted, started, completed, cancelled, delayed
- `UserStatus` - active, inactive
- `CommonStatus` - active, inactive

### Authorization
- Routes protected by Spatie role middleware
- Vendor data isolated by `vendor_id`
- Driver API protected by Sanctum tokens

### Soft Deletes
All major tables support soft deletes (`deleted_at`).

### Audit Fields
Tables include `created_by`, `updated_by`, `created_at`, `updated_at`.

---

## Documentation

Detailed documentation for each panel:

- [Admin Panel Documentation](./ADMIN_PANEL_README.md)
- [Vendor Panel Documentation](./VENDOR_PANEL_README.md)
- [Driver API Documentation](./DRIVER_API_README.md)

---

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TripTest
```

---

## Troubleshooting

### "Unauthenticated" error on API
- Ensure Sanctum is installed: `composer require laravel/sanctum`
- Run: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- Run: `php artisan migrate`

### Permissions not working
- Clear cache: `php artisan cache:clear`
- Re-seed: `php artisan db:seed --class=DatabaseSeeder`

### Storage files not accessible
- Run: `php artisan storage:link`

---

## License

Proprietary - Easy Ride

