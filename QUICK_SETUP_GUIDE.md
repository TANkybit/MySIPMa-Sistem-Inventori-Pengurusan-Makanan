# Quick Setup Guide - Dashboard Implementation

## Overview
This guide walks you through implementing the dashboard with real database data.

## Files Created
1. **database_dummy_data.sql** - Complete dummy data for testing
2. **DASHBOARD_DATABASE_MAPPING.md** - Detailed technical documentation

## 🚀 Quick Start (5 Minutes)

### Step 1: Import Dummy Data into Database
```powershell
# Open command prompt/terminal
# Navigate to your MySQL bin directory or use mysql command directly

mysql -u root -p mysipmac_mysipma < c:\laragon\www\MySIPMA_2\database_dummy_data.sql
```

**Alternative (using Laragon):**
- Open Laragon → MySQL → MySQL Console
- Run: `USE mysipmac_mysipma;`
- Run: `source c:/laragon/www/MySIPMA_2/database_dummy_data.sql;`

### Step 2: Create DashboardController
Create file: `app/Http/Controllers/DashboardController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Approval;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = Auth::user();
        $institutionId = $user->institution_id;

        // Get total orders for the institution
        $totalOrders = Order::where('institution_id', $institutionId)
            ->where('status', '!=', 'Cancelled')
            ->count();

        // Get pending approvals for the institution
        $pendingApprovals = Order::join('approvals', 'orders.id', '=', 'approvals.order_id')
            ->where('orders.institution_id', $institutionId)
            ->where('approvals.status', 0)
            ->distinct()
            ->count('orders.id');

        return view('user_dashboard', [
            'totalOrders' => $totalOrders,
            'pendingApprovals' => $pendingApprovals
        ]);
    }
}
```

### Step 3: Create/Update Models

**app/Models/Order.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
    public $timestamps = true;
}
```

**app/Models/Approval.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approvals';
    protected $guarded = [];
    public $timestamps = true;
}
```

### Step 4: Update Route
**routes/web.php**

Add this route:
```php
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
});
```

### Step 5: Update Blade Template
**resources/views/user_dashboard.blade.php**

Find and replace the statistics cards (around line 165-195):

```blade
<!-- Stat Card 1 -->
<div class="col-md-5 col-lg-4">
    <div class="stat-card text-center">
        <div class="stat-icon">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <h3 class="stat-title">Bilangan Inden</h3>
        <p class="stat-value">{{ $totalOrders ?? 0 }}</p>
    </div>
</div>

<!-- Stat Card 2 -->
<div class="col-md-5 col-lg-4">
    <div class="stat-card text-center">
        <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <h3 class="stat-title">Bilangan Inden Untuk Disahkan</h3>
        <p class="stat-value">{{ $pendingApprovals ?? 0 }}</p>
    </div>
</div>
```

## 🧪 Test the Implementation

### Login Credentials
Use any of these test accounts:

| Email | Password | Institution |
|-------|----------|------------|
| siti@example.gov.my | password123 | SK Petaling Jaya |
| ahmad@example.gov.my | password123 | SK Petaling Jaya |
| fatimah@example.gov.my | password123 | SMK Subang Jaya |
| rizal@example.gov.my | password123 | SMK Johor Bahru |
| nuraini@example.gov.my | password123 | SMK Kluang |

### Expected Results
1. **Log in with:** siti@example.gov.my / password123
2. **Dashboard should show:**
   - Bilangan Inden: **4**
   - Bilangan Inden Untuk Disahkan: **2**

---

## 📊 Database Relationship Diagram

```
┌──────────────┐
│    users     │
├──────────────┤
│ id (PK)      │
│ institution_id (FK) ─────┐
│ name         │           │
│ email        │           │
└──────────────┘           │
                           │
                    ┌──────▼──────────┐
                    │ institutions    │
                    ├─────────────────┤
                    │ id (PK)         │
                    │ name            │
                    │ address         │
                    └─────────────────┘
                           ▲
                           │
                    ┌──────┴──────────┐
                    │    orders       │
                    ├─────────────────┤
                    │ id (PK)         │
                    │ institution_id (FK)
                    │ order_no        │
                    │ status          │
                    │ total_amount    │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │   approvals     │
                    ├─────────────────┤
                    │ id (PK)         │
                    │ order_id (FK)   │
                    │ approved_by (FK)│
                    │ status (0=Pending)
                    └─────────────────┘
```

---

## 📋 Database Table Reference

### orders Table Status Values
- `Pending` - Order awaiting approval
- `In Progress` - Order approved, being processed
- `Completed` - Order delivered and received
- `Cancelled` - Order cancelled

### approvals Table Status Values
- `0` - Pending (not approved)
- `1` - Approved

---

## 🔍 Verification Queries

Run these queries to verify your data:

### Check total orders for a user
```sql
SELECT COUNT(*) as total_orders
FROM orders
WHERE institution_id = 2;
-- Expected: 4
```

### Check pending approvals
```sql
SELECT COUNT(DISTINCT o.id) as pending_approvals
FROM orders o
INNER JOIN approvals a ON o.id = a.order_id
WHERE o.institution_id = 2 AND a.status = 0;
-- Expected: 2
```

### Check user login
```sql
SELECT * FROM users WHERE email = 'siti@example.gov.my';
```

### Check orders for a user's institution
```sql
SELECT o.id, o.order_no, o.status, a.status as approval_status
FROM orders o
LEFT JOIN approvals a ON o.id = a.order_id
WHERE o.institution_id = 2;
```

---

## ⚠️ Common Issues & Solutions

### Issue: Dashboard shows 0 for both stats
**Solution:**
1. Verify dummy data was imported: `SELECT COUNT(*) FROM orders;`
2. Check if user has an institution_id: `SELECT institution_id FROM users WHERE id = (SELECT id FROM users WHERE email = AUTH_USER_EMAIL);`
3. Verify route is using DashboardController

### Issue: "Class DashboardController not found"
**Solution:**
1. Run: `php artisan make:controller DashboardController`
2. Make sure namespace is correct: `namespace App\Http\Controllers;`

### Issue: Models not found
**Solution:**
1. Create models with: `php artisan make:model Order` and `php artisan make:model Approval`
2. Ensure models are in correct namespace: `App\Models\Order`

### Issue: Foreign key errors on import
**Solution:**
1. The SQL file includes all tables in correct order
2. Make sure database doesn't have existing data conflicting with the new data
3. Clear old data: `php artisan migrate:refresh` (if you have migrations)

---

## 🔐 Security Notes

- ⚠️ **Dummy passwords are visible** - Replace with real passwords before production
- ⚠️ **Email addresses are fake** - Update with real emails for production
- ✅ All passwords are bcrypt hashed using Laravel's default
- ✅ The `created_by` and `updated_by` fields track audit trail

---

## 📝 Next Steps

After implementation:

1. **Add pagination** to see more orders/approvals
2. **Add filters** by date, status, supplier
3. **Add export** functionality (CSV/PDF)
4. **Add real-time** approval notifications
5. **Add charts** showing order trends
6. **Add search** functionality

See **DASHBOARD_DATABASE_MAPPING.md** for advanced features and enhancements.

---

## 📞 Support

For detailed information, see:
- **DASHBOARD_DATABASE_MAPPING.md** - Complete technical documentation
- **database_dummy_data.sql** - SQL source code with comments
