# Implementation Checklist & Summary

## 📋 Dashboard Implementation Checklist

### Phase 1: Database Setup ✓
- [ ] Import dummy data into database
  ```bash
  mysql -u root -p mysipmac_mysipma < database_dummy_data.sql
  ```
- [ ] Verify data imported successfully
  ```sql
  SELECT COUNT(*) FROM orders;        -- Should return: 10
  SELECT COUNT(*) FROM approvals;     -- Should return: 10
  SELECT COUNT(*) FROM users;         -- Should return: 6
  ```

### Phase 2: Model Creation ✓
- [ ] Create Order model
  ```bash
  php artisan make:model Order
  ```
- [ ] Create Approval model
  ```bash
  php artisan make:model Approval
  ```
- [ ] Update model files with correct table names and properties

### Phase 3: Controller Creation ✓
- [ ] Create DashboardController
  ```bash
  php artisan make:controller DashboardController
  ```
- [ ] Add `userDashboard()` method with proper queries

### Phase 4: Route Configuration ✓
- [ ] Add route to `routes/web.php`
  ```php
  Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
  ```

### Phase 5: View Updates ✓
- [ ] Update `user_dashboard.blade.php`
- [ ] Replace hardcoded `0` values with variables
  - `{{ $totalOrders ?? 0 }}`
  - `{{ $pendingApprovals ?? 0 }}`

### Phase 6: Testing ✓
- [ ] Test with login: siti@example.gov.my / password123
- [ ] Verify dashboard shows: 4 orders, 2 pending
- [ ] Test with other user accounts

---

## 📁 Files Created

| File | Purpose | Location |
|------|---------|----------|
| database_dummy_data.sql | Sample data for testing | `/` |
| DASHBOARD_DATABASE_MAPPING.md | Technical documentation | `/` |
| QUICK_SETUP_GUIDE.md | Step-by-step setup | `/` |
| IMPLEMENTATION_CHECKLIST.md | This file | `/` |

---

## 🗂️ Files to Create/Edit

### New Files to Create

**1. DashboardController.php**
```
Location: app/Http/Controllers/DashboardController.php
Status: [ ] Create
```

**2. Order.php Model**
```
Location: app/Models/Order.php
Status: [ ] Create
```

**3. Approval.php Model**
```
Location: app/Models/Approval.php
Status: [ ] Create
```

### Existing Files to Edit

**1. routes/web.php**
```
Location: routes/web.php
Action: [ ] Add dashboard route
Line: ~your-route-line
```

**2. user_dashboard.blade.php**
```
Location: resources/views/user_dashboard.blade.php
Action: [ ] Replace static values with dynamic variables
Lines: 165-195
```

---

## 🔗 Database Schema Summary

```
┌─────────────────────────────────────────────────────┐
│                    USERS TABLE                      │
├─────────────────────────────────────────────────────┤
│ id    │ institution_id │ name         │ email       │
├───────┼────────────────┼──────────────┼─────────────┤
│ 2     │ 2              │ Siti Nurali  │ siti@...    │
│ 3     │ 2              │ Ahmad Bin M. │ ahmad@...   │
│ 4     │ 3              │ Fatimah B.   │ fatimah@... │
└─────────────────────────────────────────────────────┘
         │
         ▼ (foreign key)
┌─────────────────────────────────────────────────────┐
│                INSTITUTIONS TABLE                   │
├─────────────────────────────────────────────────────┤
│ id    │ name                                        │
├───────┼─────────────────────────────────────────────┤
│ 2     │ Sekolah Kebangsaan Petaling Jaya            │
│ 3     │ Sekolah Menengah Kebangsaan Subang Jaya    │
└─────────────────────────────────────────────────────┘
         │
         ▼ (foreign key)
┌─────────────────────────────────────────────────────┐
│                  ORDERS TABLE                       │
├─────────────────────────────────────────────────────┤
│ id    │ order_no      │ institution_id │ status     │
├───────┼───────────────┼────────────────┼────────────┤
│ 1     │ PESAN/2026/001│ 2              │ Completed  │
│ 2     │ PESAN/2026/002│ 2              │ Completed  │
│ 3     │ PESAN/2026/003│ 2              │ Pending    │
│ 4     │ PESAN/2026/004│ 2              │ Pending    │
└─────────────────────────────────────────────────────┘
         │
         ▼ (foreign key)
┌─────────────────────────────────────────────────────┐
│                APPROVALS TABLE                      │
├─────────────────────────────────────────────────────┤
│ id    │ order_id │ approved_by │ status │ app_date  │
├───────┼──────────┼─────────────┼────────┼───────────┤
│ 1     │ 1        │ 1           │ 1      │ 2026-02-16│
│ 2     │ 2        │ 1           │ 1      │ 2026-03-11│
│ 3     │ 3        │ null        │ 0      │ NULL      │
│ 4     │ 4        │ null        │ 0      │ NULL      │
└─────────────────────────────────────────────────────┘
```

---

## 💾 SQL Queries for Dashboard

### Query 1: Total Orders
```sql
SELECT COUNT(*) as total_orders 
FROM orders 
WHERE institution_id = ? 
  AND status != 'Cancelled';
```

### Query 2: Pending Approvals
```sql
SELECT COUNT(DISTINCT o.id) as pending_approvals
FROM orders o
INNER JOIN approvals a ON o.id = a.order_id
WHERE o.institution_id = ? 
  AND a.status = 0;
```

### Test Query (View All Orders for an Institution)
```sql
SELECT 
  o.id,
  o.order_no,
  o.status,
  a.id as approval_id,
  a.status as approval_status
FROM orders o
LEFT JOIN approvals a ON o.id = a.order_id
WHERE o.institution_id = 2
ORDER BY o.order_date DESC;
```

---

## 🧪 Test Scenarios

### Scenario 1: Siti Nurhaliza (Institution 2)
```
Login: siti@example.gov.my
Password: password123
Expected Results:
  - Total Orders: 4
  - Pending Approvals: 2
  - Approved Orders: 2
  - Completed Orders: 2
```

### Scenario 2: Fatimah Binti Hassan (Institution 3)
```
Login: fatimah@example.gov.my
Password: password123
Expected Results:
  - Total Orders: 2
  - Pending Approvals: 1
  - Approved Orders: 1
  - Completed Orders: 1
```

### Scenario 3: Mohd Rizal (Institution 4)
```
Login: rizal@example.gov.my
Password: password123
Expected Results:
  - Total Orders: 2
  - Pending Approvals: 1
  - Approved Orders: 1
  - Completed Orders: 1
```

---

## 🔢 Data Statistics

### Total Dummy Data Count
- **Users:** 6
- **Institutions:** 5
- **Orders:** 10
- **Approvals:** 10
- **Suppliers:** 5
- **Contracts:** 5
- **Categories:** 5
- **Subcategories:** 8
- **Items:** 9

### Order Distribution by Institution
| Institution | Total Orders | Pending | Approved | Completed |
|-------------|--------------|---------|----------|-----------|
| SK Petaling Jaya (2) | 4 | 2 | 2 | 2 |
| SMK Subang Jaya (3) | 2 | 1 | 1 | 1 |
| SMK Johor Bahru (4) | 2 | 1 | 1 | 1 |
| SMK Kluang (5) | 2 | 1 | 1 | 1 |
| **TOTAL** | **10** | **5** | **5** | **5** |

---

## ✅ Pre-Implementation Checks

- [ ] Database `mysipmac_mysipma` exists
- [ ] Laravel project is properly set up
- [ ] Composer dependencies are installed
- [ ] Database migrations are completed
- [ ] `.env` file is configured correctly
- [ ] Authentication system is working

---

## 🚀 Implementation Steps (Copy-Paste Ready)

### Step 1: Import Database
```bash
# Open terminal in your project directory
mysql -u root -p mysipmac_mysipma < database_dummy_data.sql
# Enter password when prompted
```

### Step 2: Create Models
```bash
# From project root directory
php artisan make:model Order
php artisan make:model Approval
```

### Step 3: Create Controller
```bash
php artisan make:controller DashboardController
```

### Step 4: Update Files
Copy-paste the code from QUICK_SETUP_GUIDE.md into:
1. `app/Models/Order.php`
2. `app/Models/Approval.php`
3. `app/Http/Controllers/DashboardController.php`
4. `routes/web.php` (add route)
5. `resources/views/user_dashboard.blade.php` (update template)

### Step 5: Test
```bash
# Start your Laravel development server
php artisan serve

# Navigate to: http://localhost:8000/user/dashboard
# Login with: siti@example.gov.my / password123
```

---

## 📊 Expected Dashboard Output

After implementation, your dashboard should display:

```
┌────────────────────────────────────────────────┐
│         PAPAN PEMUKA (USER DASHBOARD)          │
├────────────────────────────────────────────────┤
│                                                │
│  Selamat datang, Puan Siti Nurhaliza!         │
│  Pantau statistik dan status inden anda        │
│  di sini.                                      │
│                                                │
│  ┌──────────────┐    ┌──────────────┐         │
│  │    4         │    │      2       │         │
│  │ Bilangan     │    │ Bilangan     │         │
│  │ Inden        │    │ Inden Untuk  │         │
│  │              │    │ Disahkan     │         │
│  └──────────────┘    └──────────────┘         │
│                                                │
│  ┌──────────────────────────────────┐         │
│  │   CIPTA INDEN BARU               │         │
│  │   Isi borang inden digital untuk │         │
│  │   membuat permohonan baru        │         │
│  │                      [Borang]    │         │
│  └──────────────────────────────────┘         │
│                                                │
└────────────────────────────────────────────────┘
```

---

## 📞 Troubleshooting Guide

### Problem: "Table doesn't exist"
```
Solution: Run database import again
mysql -u root -p mysipmac_mysipma < database_dummy_data.sql
```

### Problem: "Class not found" error
```
Solution: Run composer autoload
composer dump-autoload
php artisan cache:clear
```

### Problem: Dashboard shows 0 numbers
```
Solution: Check these queries:
1. SELECT COUNT(*) FROM orders;
2. SELECT COUNT(*) FROM approvals;
3. SELECT * FROM users WHERE email = 'logged-in-user-email';
4. Verify user's institution_id matches orders.institution_id
```

### Problem: 404 error on route
```
Solution: Make sure route is added to routes/web.php
and within the correct middleware group
```

---

## 📝 Notes

- The dummy data includes realistic scenarios with mixed order statuses
- All passwords are bcrypt hashed (use plaintext 'password123')
- Dates are set to 2026 to match your application's timeline
- Foreign key relationships are maintained throughout
- The data is designed to test all dashboard functionality

---

## ✨ Summary

**Total Files Created:** 4 files
- database_dummy_data.sql (500+ lines)
- DASHBOARD_DATABASE_MAPPING.md
- QUICK_SETUP_GUIDE.md
- IMPLEMENTATION_CHECKLIST.md (this file)

**Estimated Setup Time:** 15-30 minutes

**Test Users Provided:** 5 different accounts with various institutions

**Expected Result:** Dashboard displays dynamic data from database based on logged-in user's institution
