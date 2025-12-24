# Easy Ride - Admin Panel Documentation

## Overview

The Admin Panel is the central management hub for the Easy Ride B2B Employee Cab Management System. Only users with the `admin` role can access this panel.

---

## Default Login Credentials

```
URL:      http://your-domain/login
Email:    pavithra@gmail.com
Password: 12345678
```

After login, admin users are redirected to `/admin/dashboard`.

---

## Main Modules

### 1. Dashboard (`/admin/dashboard`)

Overview of the entire system at a glance:

| Widget | Description |
|--------|-------------|
| Total Vendors Active | Count of vendors with status = active |
| Total Drivers Active | Count of drivers with status = active |
| Total Trips Today | Count of trips scheduled for today |
| Pending Trip Approvals | Count of trips with status = pending |
| Daily Revenue Summary | Sum of estimated_cost from completed trips today |
| Live Trip Status | Table showing trips currently in progress (started/accepted/assigned) |

---

### 2. Vendor Management (`/admin/vendors`)

Manage IT companies (vendors) who use the cab service.

**Features:**
- List all vendors with company info
- Create new vendor
- Edit vendor details
- Delete (soft delete) vendor

**Vendor Fields:**
- Company Name
- GST Number
- Address, City, State, Pincode
- Contact Person, Email, Phone
- Status (active/inactive)

---

### 3. Driver Management (`/admin/drivers`)

Manage cab drivers assigned to vendors.

**Features:**
- List all drivers with vendor info
- Create new driver (creates user account with `driver` role)
- Edit driver details
- View driver profile with KYC documents & vehicle info
- Upload driver documents (DL, RC, Insurance)
- Assign/update vehicle to driver

**Driver Fields:**
- Name, Mobile, Email
- Vendor (required)
- Status (active/inactive)
- Rating

---

### 4. User Management (`/admin/users`)

Manage all system users (admin, vendor, driver).

**Features:**
- List all users with roles
- Create new user with role assignment
- Edit user details and role
- Password management (auto-generate or manual)
- Delete (soft delete) user

**User Types:**
| Role | vendor_id | Access |
|------|-----------|--------|
| admin | NULL | Full system access |
| vendor | Required | Own vendor data only |
| driver | Required | API access only (no web login) |

---

### 5. Route Management (`/admin/routes`)

Define pickup/drop routes for employee transportation.

**Features:**
- List all routes
- Create route with pickup points
- Assign default driver and vehicle to route
- Edit/delete routes

**Route Fields:**
- Name
- Vendor
- Pickup Time
- Weekly Fixed (yes/no)
- Default Driver & Vehicle

---

### 6. Trip Management (`/admin/trips`)

Manage all trip requests and assignments.

**Features:**
- List trips with filters (status, type, date)
- View trip details with route points
- Edit trip (assign driver, vehicle, change status)
- Approve pending trips
- Cancel trips
- Mark trips as delayed (sends alerts)

**Trip Statuses:**
`pending` → `approved` → `assigned` → `accepted` → `started` → `completed`

Also: `cancelled`, `delayed`

**Trip Types:**
- Single (one-time trip)
- Weekly (recurring schedule)
- Special (late night, emergency, airport, outstation)

---

### 7. Billing & Payments (`/admin/billing`)

Manage vendor invoices, driver payments, and operational expenses.

**Features:**
- **Generate Vendor Invoice**: Select vendor, date range, creates invoice from completed trips
- **Send Invoice**: Marks invoice as sent, triggers payment due alert
- **Mark as Paid**: Records payment
- **Record Driver Payment**: Daily/weekly payments to drivers
- **Track Expenses**: Fuel, maintenance, toll, parking, insurance, other

**Summary Cards:**
- Pending Invoices Total
- Driver Payments This Month
- Expenses This Month

---

### 8. Notifications (`/admin/notifications`)

View all system notifications sent to vendors and drivers.

**Notification Types:**
- Trip Delay
- Vehicle Change
- Payment Due
- Trip Assigned
- Pickup Reminder
- Route Change
- Trip Status Update
- Document Expiry

---

### 9. Support / Helpdesk (`/admin/support-tickets`)

Manage support tickets from vendors and drivers.

**Features:**
- List all tickets (open, in_progress, closed)
- View ticket details with conversation thread
- Reply to tickets
- Assign tickets to support agents
- Change ticket status

---

### 10. Reports (`/admin/reports`)

Generate and view various reports.

**Available Reports:**
- Trip-wise Report (with date filters)
- Vendor-wise Summary
- Driver Performance

*Note: PDF/Excel export to be implemented.*

---

## Sidebar Navigation

```
MANAGEMENT
├── Vendors
├── Drivers
├── Users

OPERATIONS
├── Routes
├── Trips

FINANCE
├── Billing

COMMUNICATION
├── Notifications
├── Support

ANALYTICS
├── Reports
```

---

## Permissions (Spatie)

Admin role has all permissions:

```
manage_users
manage_roles
manage_permissions
manage_vendors
manage_drivers
manage_routes
manage_trips
manage_billing
manage_notifications
manage_support
view_reports
```

---

## Technical Notes

- All routes use `role:admin` middleware
- Soft deletes enabled on all major tables
- Audit fields: `created_by`, `updated_by`, `created_at`, `updated_at`
- Authorization via Spatie Permission middleware and policies

