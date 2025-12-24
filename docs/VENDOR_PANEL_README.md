# Easy Ride - Vendor Panel Documentation

## Overview

The Vendor Panel allows IT companies to manage their employee transportation needs. Users with the `vendor` role can access this panel and view only their own vendor's data.

---

## Login

```
URL: http://your-domain/login
```

Vendor users are created by Admin. After login, vendor users are redirected to `/vendor/dashboard`.

---

## Main Modules

### 1. Dashboard (`/vendor/dashboard`)

Quick overview of your company's transportation:

| Widget | Description |
|--------|-------------|
| Total Trips Today | Your company's trips scheduled for today |
| Live Trips | Count of currently active trips |
| Active Drivers | Count of drivers assigned to your company |
| Payment Due Alert | Warning if invoices are due within 7 days |
| Next Scheduled Trips | Upcoming 5 trips |
| Live Trip Tracking | Real-time status of ongoing trips |
| Drivers Assigned | List of your assigned drivers |
| Vehicle Details | Vehicles assigned to your company |

---

### 2. Trip Booking (`/vendor/trips`)

Request new trips for your employees.

#### Trip Types

**1. Single Trip**
- One-time trip request
- Select date and time
- Choose existing route or ad-hoc

**2. Weekly Fixed Route**
- Recurring weekly schedule
- Select days of week (Mon-Sun)
- Set pickup time
- Define start and end date
- System creates individual trips for each day

**3. Special Request**
- Late Night trips
- Emergency trips
- Airport Pickup/Drop
- Outstation trips
- Set priority (Normal/High/Urgent)
- Add special instructions

#### Booking Options

- **Auto Assign Driver**: System assigns available driver
- **Manual Assign Later**: Admin will assign driver

#### Trip Workflow

1. Vendor creates trip request → Status: `pending`
2. Admin approves → Status: `approved`
3. Driver assigned → Status: `assigned`
4. Driver accepts → Status: `accepted`
5. Driver starts trip → Status: `started`
6. Driver completes → Status: `completed`

---

### 3. Employee Routes (`/vendor/routes`)

Define standard routes for your employee transportation.

**Features:**
- List your company's routes
- Create new route with pickup/drop points
- View route details

**Route Fields:**
- Route Name
- Pickup Time
- Weekly Fixed (for recurring routes)

**Route Points:**
- Type: Pickup or Drop
- Location address
- Time
- Sequence order

---

### 4. Billing & Expenses (`/vendor/billing`)

View your company's invoices and payment status.

**Features:**
- List all invoices
- View invoice details with trip breakdown
- Check due dates
- Payment status tracking

**Invoice Statuses:**
| Status | Description |
|--------|-------------|
| Pending | Invoice generated, not yet sent |
| Sent | Invoice sent, awaiting payment |
| Paid | Payment received |

**Invoice Fields:**
- Invoice Number
- Invoice Date
- Due Date
- Period (From - To)
- Total Amount
- Tax Amount (18% GST)
- Payable Amount

---

### 5. Notifications (`/vendor/notifications`)

Receive important updates about your trips.

**Alert Types:**
- Trip Delay - When your trip is delayed
- Vehicle Change - When assigned vehicle changes
- Trip Status Update - When trip status changes
- Payment Due - When invoice payment is due

---

### 6. Support (`/vendor/support-tickets`)

Get help from Easy Ride admin team.

**Features:**
- View your support tickets
- Raise new support ticket
- Chat with Easy Ride admin
- Track ticket status

**Ticket Statuses:**
- Open
- In Progress
- Closed

---

## Sidebar Navigation

```
TRIP MANAGEMENT
├── Trip Booking
├── Employee Routes

FINANCE
├── Billing & Expenses

COMMUNICATION
├── Notifications
├── Support
```

---

## Permissions (Spatie)

Vendor role has these permissions:

```
view_own_trips
create_trip_request
view_billing
view_trip_cost
raise_support_ticket
```

---

## Important Notes

1. **Data Isolation**: You can only see your own company's data
2. **No User Management**: Only admin can create/manage users
3. **Trip Approval**: All trips require admin approval before execution
4. **Billing**: Invoices are generated monthly by admin

---

## Quick Actions

| Action | How To |
|--------|--------|
| Book a single trip | Trip Booking → Single Trip → Fill form → Submit |
| Set up weekly schedule | Trip Booking → Weekly Fixed Route → Select days → Submit |
| Request emergency trip | Trip Booking → Special Request → Emergency → Submit |
| Create employee route | Employee Routes → Create → Add pickup/drop points |
| View invoice | Billing → Click on invoice number |
| Raise support ticket | Support → Raise Ticket → Fill form → Submit |
| Track live trip | Dashboard → Live Trip Tracking table |

---

## Technical Notes

- All routes use `role:vendor` middleware
- Vendor ID automatically applied to all queries
- Only own vendor data is accessible
- Authorization via Spatie Permission middleware

