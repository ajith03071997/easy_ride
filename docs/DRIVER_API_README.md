# Easy Ride - Driver App API Documentation

## Overview

The Driver API provides endpoints for the mobile driver app. All endpoints except login require authentication using Laravel Sanctum tokens.

**Base URL:** `http://your-domain/api/v1/driver`

---

## Setup Requirements

### 1. Install Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Configure Sanctum

In `app/Http/Kernel.php`, add to `api` middleware group:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    // ... other middleware
],
```

### 3. Update User Model

Ensure `App\Models\User` uses the `HasApiTokens` trait:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    // ...
}
```

---

## Authentication

### Login

**POST** `/api/v1/driver/login`

Get authentication token for the driver app.

**Request:**
```json
{
    "email": "driver@example.com",
    "password": "password123",
    "device_name": "iPhone 14 Pro"
}
```

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| email | string | Yes | Driver's email address |
| password | string | Yes | Driver's password |
| device_name | string | No | Device identifier (default: "driver-app") |

**Response (Success - 200):**
```json
{
    "token": "1|abc123xyz789...",
    "user": {
        "id": 5,
        "name": "John Driver",
        "email": "driver@example.com"
    }
}
```

**Response (Error - 401):**
```json
{
    "message": "Invalid credentials"
}
```

**Note:** Only users with `driver` role can login via this endpoint.

---

### Using the Token

Include the token in all subsequent requests:

```
Authorization: Bearer 1|abc123xyz789...
```

---

### Get Current User

**GET** `/api/v1/driver/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "id": 5,
    "name": "John Driver",
    "email": "driver@example.com"
}
```

---

### Logout

**POST** `/api/v1/driver/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Logged out"
}
```

---

## Trips

### Get Today's Trips

**GET** `/api/v1/driver/trips/today`

Get all trips assigned to the driver for today.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
[
    {
        "id": 101,
        "vendor_id": 1,
        "route_id": 5,
        "driver_id": 3,
        "vehicle_id": 2,
        "trip_type": "single",
        "scheduled_date": "2024-12-18",
        "scheduled_time": "08:30:00",
        "status": "assigned",
        "route": {
            "id": 5,
            "name": "Office Route A",
            "points": [
                {
                    "id": 1,
                    "type": "pickup",
                    "location": "123 Main St, City",
                    "time": "08:30:00",
                    "sequence": 1
                },
                {
                    "id": 2,
                    "type": "pickup",
                    "location": "456 Oak Ave, City",
                    "time": "08:45:00",
                    "sequence": 2
                },
                {
                    "id": 3,
                    "type": "drop",
                    "location": "Tech Park, IT Hub",
                    "time": "09:30:00",
                    "sequence": 3
                }
            ]
        }
    }
]
```

---

### Get Trip Details

**GET** `/api/v1/driver/trips/{trip_id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "id": 101,
    "vendor_id": 1,
    "route_id": 5,
    "driver_id": 3,
    "vehicle_id": 2,
    "trip_type": "single",
    "special_type": null,
    "priority": "normal",
    "special_instructions": null,
    "scheduled_date": "2024-12-18",
    "scheduled_time": "08:30:00",
    "status": "assigned",
    "estimated_cost": 500.00,
    "route": {
        "id": 5,
        "name": "Office Route A",
        "pickup_time": "08:30:00",
        "points": [...]
    }
}
```

---

### Accept Trip

**POST** `/api/v1/driver/trips/{trip_id}/accept`

Driver accepts the assigned trip.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Trip accepted",
    "status": "accepted"
}
```

---

### Start Trip

**POST** `/api/v1/driver/trips/{trip_id}/start`

Driver starts the trip (begins journey).

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Trip started",
    "status": "started"
}
```

---

### Complete Trip

**POST** `/api/v1/driver/trips/{trip_id}/complete`

Driver marks trip as completed.

**Headers:**
```
Authorization: Bearer {token}
```

**Request (Optional):**
```json
{
    "distance_km": 25.5,
    "completion_report": {
        "notes": "All passengers dropped safely",
        "issues": null
    }
}
```

**Response:**
```json
{
    "message": "Trip completed",
    "status": "completed"
}
```

---

### Update Location (Live Tracking)

**POST** `/api/v1/driver/trips/{trip_id}/location`

Send driver's current location for live tracking.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
    "lat": 12.9716,
    "lng": 77.5946
}
```

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| lat | number | Yes | Latitude coordinate |
| lng | number | Yes | Longitude coordinate |

**Response:**
```json
{
    "message": "Location updated"
}
```

**Note:** Call this every 30-60 seconds during active trips.

---

## Earnings

### Daily Earnings

**GET** `/api/v1/driver/earnings/daily`

Get today's earnings summary.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "date": "2024-12-18",
    "trip_earnings": 1500.00,
    "payments": [
        {
            "id": 10,
            "driver_id": 3,
            "payment_date": "2024-12-18",
            "amount": 1200.00,
            "frequency": "daily",
            "status": "pending"
        }
    ]
}
```

---

### Weekly Earnings

**GET** `/api/v1/driver/earnings/weekly`

Get current week's earnings summary.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "from": "2024-12-16",
    "to": "2024-12-22",
    "trip_earnings": 7500.00,
    "payments": [
        {
            "id": 10,
            "amount": 1200.00,
            "payment_date": "2024-12-18",
            "frequency": "daily"
        },
        {
            "id": 11,
            "amount": 1500.00,
            "payment_date": "2024-12-17",
            "frequency": "daily"
        }
    ]
}
```

---

## Vehicle & Documents

### Get Vehicle Info

**GET** `/api/v1/driver/vehicle`

Get driver's assigned vehicle details.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "vehicle": {
        "id": 2,
        "driver_id": 3,
        "vehicle_number": "KA01AB1234",
        "vehicle_type": "Sedan",
        "vehicle_model": "Honda City",
        "status": "active",
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

---

### Get Documents

**GET** `/api/v1/driver/vehicle/documents`

Get driver's uploaded KYC documents.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
[
    {
        "id": 1,
        "driver_id": 3,
        "document_type": "DL",
        "file_path": "driver-documents/abc123.pdf",
        "expiry_date": "2025-06-15",
        "created_at": "2024-01-15T10:00:00.000000Z"
    },
    {
        "id": 2,
        "driver_id": 3,
        "document_type": "RC",
        "file_path": "driver-documents/xyz789.pdf",
        "expiry_date": "2026-01-20",
        "created_at": "2024-01-15T10:05:00.000000Z"
    }
]
```

---

### Upload Document

**POST** `/api/v1/driver/vehicle/documents`

Upload a KYC document.

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request (Form Data):**
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| type | string | Yes | Document type: `DL`, `RC`, or `Insurance` |
| file | file | Yes | PDF, JPG, JPEG, or PNG file |
| expiry_date | date | No | Document expiry date (YYYY-MM-DD) |

**cURL Example:**
```bash
curl -X POST "http://your-domain/api/v1/driver/vehicle/documents" \
  -H "Authorization: Bearer {token}" \
  -F "type=DL" \
  -F "file=@/path/to/driving_license.pdf" \
  -F "expiry_date=2025-06-15"
```

**Response (201):**
```json
{
    "id": 3,
    "driver_id": 3,
    "document_type": "DL",
    "file_path": "driver-documents/new_file.pdf",
    "expiry_date": "2025-06-15",
    "created_at": "2024-12-18T12:00:00.000000Z"
}
```

---

## Notifications

### Get Notifications

**GET** `/api/v1/driver/notifications`

Get driver's notifications.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
[
    {
        "id": 15,
        "user_id": 5,
        "type": "trip_assigned",
        "title": "New Trip Assigned",
        "message": "New trip #101 has been assigned to you for 2024-12-18.",
        "data": {
            "trip_id": 101,
            "scheduled_date": "2024-12-18",
            "scheduled_time": "08:30:00"
        },
        "read": false,
        "created_at": "2024-12-18T07:00:00.000000Z"
    },
    {
        "id": 14,
        "user_id": 5,
        "type": "pickup_reminder",
        "title": "Pickup Time Reminder",
        "message": "Reminder: Trip #101 pickup is scheduled at 08:30.",
        "data": {
            "trip_id": 101,
            "scheduled_time": "08:30:00"
        },
        "read": true,
        "created_at": "2024-12-18T07:30:00.000000Z"
    }
]
```

**Notification Types:**
| Type | Description |
|------|-------------|
| trip_assigned | New trip assigned to driver |
| pickup_reminder | Reminder before pickup time |
| route_change | Route has been changed |
| trip_delay | Trip has been delayed |
| vehicle_change | Assigned vehicle changed |
| document_expiry | Document expiring soon |

---

### Mark Notification as Read

**POST** `/api/v1/driver/notifications/{notification_id}/read`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Notification marked as read"
}
```

---

## Support

### Get Support Contact

**GET** `/api/v1/driver/support/contact`

Get Easy Ride admin contact info.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "phone": "+91-9876543210",
    "email": "support@easyride.com"
}
```

---

### Report Vehicle Issue

**POST** `/api/v1/driver/support/vehicle-issue`

Report a vehicle problem to admin.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
    "message": "AC not working, needs service"
}
```

**Response (201):**
```json
{
    "message": "Vehicle issue reported",
    "ticket_id": 25
}
```

---

### Emergency Button

**POST** `/api/v1/driver/support/emergency`

Trigger emergency alert to admin.

**Headers:**
```
Authorization: Bearer {token}
```

**Request (Optional):**
```json
{
    "message": "Accident at Highway 5, need immediate help"
}
```

**Response (201):**
```json
{
    "message": "Emergency raised",
    "ticket_id": 26
}
```

---

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
    "message": "This action is unauthorized."
}
```

### 422 Validation Error
```json
{
    "message": "The email field is required.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### 404 Not Found
```json
{
    "message": "No query results for model [App\\Models\\Trip] 999"
}
```

---

## API Endpoints Summary

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/login` | Get auth token |
| GET | `/me` | Get current user |
| POST | `/logout` | Logout |
| GET | `/trips/today` | Today's trips |
| GET | `/trips/{id}` | Trip details |
| POST | `/trips/{id}/accept` | Accept trip |
| POST | `/trips/{id}/start` | Start trip |
| POST | `/trips/{id}/complete` | Complete trip |
| POST | `/trips/{id}/location` | Update location |
| GET | `/earnings/daily` | Daily earnings |
| GET | `/earnings/weekly` | Weekly earnings |
| GET | `/vehicle` | Vehicle info |
| GET | `/vehicle/documents` | Get documents |
| POST | `/vehicle/documents` | Upload document |
| GET | `/notifications` | Get notifications |
| POST | `/notifications/{id}/read` | Mark as read |
| GET | `/support/contact` | Support contact |
| POST | `/support/vehicle-issue` | Report vehicle issue |
| POST | `/support/emergency` | Emergency alert |

---

## Mobile App Integration Guide

### 1. Store Token Securely

After login, store the token in secure storage (Keychain for iOS, EncryptedSharedPreferences for Android).

### 2. Token Refresh

Tokens don't expire by default. If you want auto-expiry, configure in `config/sanctum.php`:

```php
'expiration' => 60 * 24, // 24 hours
```

### 3. Location Updates

Implement background location service to call `/trips/{id}/location` every 30-60 seconds during active trips.

### 4. Push Notifications

For real-time notifications, integrate Firebase Cloud Messaging (FCM) and store device tokens. The backend AlertService can be extended to send FCM notifications.

### 5. Offline Support

Cache today's trips locally. Queue location updates when offline and sync when online.

---

## Testing with cURL

```bash
# Login
curl -X POST "http://localhost:8000/api/v1/driver/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"driver@example.com","password":"12345678"}'

# Get today's trips
curl -X GET "http://localhost:8000/api/v1/driver/trips/today" \
  -H "Authorization: Bearer {token}"

# Accept trip
curl -X POST "http://localhost:8000/api/v1/driver/trips/101/accept" \
  -H "Authorization: Bearer {token}"

# Start trip
curl -X POST "http://localhost:8000/api/v1/driver/trips/101/start" \
  -H "Authorization: Bearer {token}"

# Update location
curl -X POST "http://localhost:8000/api/v1/driver/trips/101/location" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"lat":12.9716,"lng":77.5946}'

# Complete trip
curl -X POST "http://localhost:8000/api/v1/driver/trips/101/complete" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"distance_km":25.5}'
```

---

## Testing with Postman

1. Create environment variable `base_url` = `http://localhost:8000/api/v1/driver`
2. Create environment variable `token` (empty initially)
3. In Login request, add script to save token:
   ```javascript
   pm.environment.set("token", pm.response.json().token);
   ```
4. For other requests, set Authorization header:
   ```
   Bearer {{token}}
   ```

