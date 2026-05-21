# Dashboard to Database Mapping Guide

## Current Dashboard Structure
The user dashboard displays:
1. **User greeting** with name (from authenticated user)
2. **Bilangan Inden** (Total Orders Count)
3. **Bilangan Inden Untuk Disahkan** (Pending Approvals Count)

---

## Database Table Mapping

### Primary Tables Involved:
```
users (logged-in user info)
    ↓
institutions (user's institution)
    ↓
orders (orders for that institution)
    ↓
approvals (approval status for orders)
```

### Detailed Mapping:

| Dashboard Element | Source Table | Join Chain | Notes |
|---|---|---|---|
| User Name | `users.name` | Direct (Auth::user()) | Already working in the template |
| Bilangan Inden | `orders` | COUNT(*) WHERE institution_id = user.institution_id | Total orders for user's institution |
| Bilangan Inden Untuk Disahkan | `approvals` + `orders` | COUNT WHERE orders.institution_id = user.institution_id AND approvals.status = 0 | Orders with pending approvals |

---

## Database Queries

### Query 1: Get Total Orders for User's Institution
```sql
SELECT COUNT(*) as total_orders 
FROM orders 
WHERE institution_id = ? AND status != 'Cancelled'
```
**Parameters:** `Auth::user()->institution_id`

### Query 2: Get Pending Approvals for User's Institution
```sql
SELECT COUNT(DISTINCT o.id) as pending_approvals
FROM orders o
INNER JOIN approvals a ON o.id = a.order_id
WHERE o.institution_id = ? AND a.status = 0
```
**Parameters:** `Auth::user()->institution_id`

### Query 3: Alternative - Get Orders Waiting for Approval
```sql
SELECT COUNT(*) as pending_approvals
FROM orders
WHERE institution_id = ? 
  AND id NOT IN (
    SELECT order_id FROM approvals WHERE status = 1
  )
```

---

## Data Dictionary

### users Table
```
id ..................... Primary Key
institution_id ......... Foreign Key (institutions.id)
role_id ................ Foreign Key (roles.id)
position_id ............ Foreign Key (positions.id)
name ................... User's full name
email .................. User's email
phone_number ........... Contact number
password ............... Hashed password
image .................. Profile image URL
status ................. 1=Active, 0=Inactive
created_at ............. Creation date
created_by ............. User ID who created
updated_at ............. Last update date
updated_by ............. User ID who updated
```

### orders Table
```
id ..................... Primary Key
order_no ............... Order number (unique)
institution_id ......... Foreign Key (institutions.id)
supplier_id ............ Foreign Key (suppliers.id)
contract_id ............ Foreign Key (contracts.id)
order_date ............. Date order was placed
total_amount ........... Total order value
status ................. 'Pending', 'In Progress', 'Completed', 'Cancelled'
remarks ................ Order notes/remarks
created_at ............. Creation date
created_by ............. User ID who created
updated_at ............. Last update date
updated_by ............. User ID who updated
```

### approvals Table
```
id ..................... Primary Key
order_id ............... Foreign Key (orders.id)
approved_by ............ Foreign Key (users.id)
approval_date .......... Date of approval
status ................. 1=Approved, 0=Pending
remarks ................ Approval notes
created_at ............. Creation date
created_by ............. User ID who created
updated_at ............. Last update date
updated_by ............. User ID who updated
```

---

## Dummy Data Summary

### Test User: Puan Siti Nurhaliza
- **ID:** 2
- **Email:** siti@example.gov.my
- **Institution:** Sekolah Kebangsaan Petaling Jaya (ID: 2)
- **Role:** User (ID: 2)
- **Position:** Pegawai Pengurusan Barang Kraf (ID: 3)
- **Password:** password123 (hashed)

### Expected Dashboard Results for Test User
```
Bilangan Inden: 4
  - PESAN/2026/001 (Completed)
  - PESAN/2026/002 (Completed)
  - PESAN/2026/003 (Pending)
  - PESAN/2026/004 (Pending)

Bilangan Inden Untuk Disahkan: 2
  - PESAN/2026/003 (Status = 0/Pending)
  - PESAN/2026/004 (Status = 0/Pending)
```

---

## Laravel Controller Implementation

### Create/Update Controller Method
**File:** `app/Http/Controllers/DashboardController.php`

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

### Update Blade Template
**File:** `resources/views/user_dashboard.blade.php`

Replace the hardcoded `0` values with variables:

```blade
<!-- Stat Card 1 - Total Orders -->
<div class="col-md-5 col-lg-4">
    <div class="stat-card text-center">
        <div class="stat-icon">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <h3 class="stat-title">Bilangan Inden</h3>
        <p class="stat-value">{{ $totalOrders ?? 0 }}</p>
    </div>
</div>

<!-- Stat Card 2 - Pending Approvals -->
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

---

## Testing Instructions

### Step 1: Import Dummy Data
```bash
mysql -u root -p mysipmac_mysipma < database_dummy_data.sql
```

### Step 2: Create/Update Controller
Create the `DashboardController` with the code above.

### Step 3: Update Route
**File:** `routes/web.php`
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
});
```

### Step 4: Create Models (if not exist)
```bash
php artisan make:model Order
php artisan make:model Approval
```

**Order Model:** `app/Models/Order.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
}
```

**Approval Model:** `app/Models/Approval.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approvals';
    protected $guarded = [];
}
```

### Step 5: Test the Dashboard
- Log in with credentials:
  - **Email:** siti@example.gov.my
  - **Password:** password123
- Dashboard should display:
  - **Bilangan Inden:** 4
  - **Bilangan Inden Untuk Disahkan:** 2

---

## Additional Dashboard Enhancements

### 1. Show Recent Orders
```blade
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="action-card">
            <h4>Pesanan Terbaru</h4>
            @forelse($recentOrders as $order)
                <p>{{ $order->order_no }} - {{ $order->status }}</p>
            @empty
                <p class="text-muted">Tiada pesanan terbaru</p>
            @endforelse
        </div>
    </div>
</div>
```

### 2. Show Pending Orders Only
```php
$pendingOrders = Order::where('institution_id', $institutionId)
    ->where('status', 'Pending')
    ->orWhere('status', 'In Progress')
    ->get();
```

### 3. Add Notification Count
```blade
<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
    style="font-size: 0.65rem;">
    {{ $pendingApprovals }}
    <span class="visually-hidden">Inden belum disah</span>
</span>
```

---

## Query Performance Tips

### For Large Datasets:
1. Add indexes on frequently queried columns:
```sql
ALTER TABLE orders ADD INDEX idx_institution_id (institution_id);
ALTER TABLE orders ADD INDEX idx_status (status);
ALTER TABLE approvals ADD INDEX idx_order_id (order_id);
ALTER TABLE approvals ADD INDEX idx_status (status);
```

2. Cache dashboard stats:
```php
$totalOrders = Cache::remember("orders.{$institutionId}", 3600, function() use ($institutionId) {
    return Order::where('institution_id', $institutionId)->count();
});
```

---

## Test Data Login Credentials

| User | Email | Password | Institution | Expected Totals |
|------|-------|----------|------------|-----------------|
| Siti Nurhaliza | siti@example.gov.my | password123 | Sekolah Kebangsaan Petaling Jaya | 4 orders, 2 pending |
| Ahmad Bin Mohd | ahmad@example.gov.my | password123 | Sekolah Kebangsaan Petaling Jaya | 4 orders, 2 pending |
| Fatimah Binti Hassan | fatimah@example.gov.my | password123 | SMK Subang Jaya | 2 orders, 1 pending |
| Tuan Mohd Rizal | rizal@example.gov.my | password123 | SMK Johor Bahru | 2 orders, 1 pending |
| Cik Nur Aini | nuraini@example.gov.my | password123 | SMK Kluang | 2 orders, 1 pending |

---

## Notes

- All passwords are hashed using bcrypt (algorithm used by Laravel)
- The `created_by` and `updated_by` fields typically reference the `users` table
- Status values in approvals: 1 = Approved/Completed, 0 = Pending
- The dummy data is realistic and covers various scenarios (completed, pending, in progress)
- Total orders and pending approvals vary by institution for testing purposes
