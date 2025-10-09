# Role-Based Access Control - Visual Guide

## 🎭 Role Hierarchy

```
┌─────────────────────────────────────────────────────────────┐
│                        ADMIN ROLE                            │
│                     (Full System Access)                     │
├─────────────────────────────────────────────────────────────┤
│ ✅ Dashboard                                                 │
│ ✅ Categories Management                                     │
│ ✅ Products Management                                       │
│ ✅ Users Management                                          │
│ ✅ Levels Management                                         │
│ ✅ Orders Management                                         │
│ ✅ News Management                                           │
│ ✅ Suggestions Management                                    │
│ ✅ Blog Categories Management                                │
│ ✅ Blog Posts Management                                     │
│ ✅ Banners Management                                        │
│ ✅ Courier Services Management                               │
│ ✅ Shipments Management                                      │
│ ✅ Shipment Dashboard                                        │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    ORDER TAKER ROLE                          │
│            (Orders & Shipments Access Only)                  │
├─────────────────────────────────────────────────────────────┤
│ ✅ Dashboard                                                 │
│ ✅ Orders Management                                         │
│ ✅ Shipments Management                                      │
│ ✅ Shipment Dashboard                                        │
│ ❌ Categories, Products, Users, Levels                       │
│ ❌ News, Suggestions, Blog, Banners                          │
│ ❌ Courier Services Configuration                            │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                      SUPPORT ROLE                            │
│            (Similar to Order Taker)                          │
├─────────────────────────────────────────────────────────────┤
│ ✅ Dashboard                                                 │
│ ✅ Orders Management                                         │
│ ✅ Shipments Management                                      │
│ ✅ Shipment Dashboard                                        │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                        USER ROLE                             │
│                  (Frontend Customer)                         │
├─────────────────────────────────────────────────────────────┤
│ ✅ User Dashboard                                            │
│ ✅ Profile Management                                        │
│ ✅ Order History                                             │
│ ✅ Product Reviews                                           │
│ ✅ Referrals                                                 │
│ ❌ Admin Panel Access                                        │
└─────────────────────────────────────────────────────────────┘
```

## 🎨 Sidebar Navigation Flow

### Admin Sidebar (Full Menu)
```
┌────────────────────────────┐
│      Admin Panel           │
├────────────────────────────┤
│ 🏠 Dashboard               │
│ 📂 Categories              │
│ 🏷️  Products               │
│ 👥 Users                   │
│ 📊 Levels                  │
│ 🛒 Orders                  │
│ 📰 News                    │
│ 💡 Suggestions             │
│ 📁 Blog Categories         │
│ 📝 Blog                    │
│ 🖼️  Banners                │
│ 🚚 Courier Services        │
│ 📦 Shipments               │
│ 📈 Shipment Dashboard      │
│ 🚪 Logout                  │
└────────────────────────────┘
```

### Order Taker Sidebar (Limited Menu)
```
┌────────────────────────────┐
│      Admin Panel           │
├────────────────────────────┤
│ 🏠 Dashboard               │
│ 🛒 Orders                  │
│ 📦 Shipments               │
│ 📈 Shipment Dashboard      │
│ 🚪 Logout                  │
└────────────────────────────┘
```

## 🔐 Route Protection

### Admin Only Routes
```
/admin/categories/*
/admin/products/*
/admin/users/*
/admin/levels/*
/admin/news/*
/admin/suggestions/*
/admin/blog-categories/*
/admin/posts/*
/admin/banners/*
/admin/courier-services/*
```

### Admin + Order Taker Routes
```
/admin/orders/*
/admin/shipments/*
/admin/dashboard/shipments
```

## 🎯 User Management Flow

### Creating a New User
```
┌─────────────────────────────────────────────────────────────┐
│                  Create New User Form                        │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Name:          [________________]                           │
│  Email:         [________________]                           │
│  Mobile:        [________________]                           │
│  Referral Code: [________________]  (Optional)               │
│  Extra Discount:[____]              (Optional)               │
│                                                              │
│  Role:          [▼ Select Role   ]  ⚠️ REQUIRED              │
│                 ├─ Admin                                     │
│                 ├─ Order Taker       ← NEW                   │
│                 ├─ Support                                   │
│                 └─ User                                      │
│                                                              │
│  Password:      [________________]                           │
│  Confirm:       [________________]                           │
│                                                              │
│  [Create User]  [Cancel]                                     │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Users Table Display
```
┌─────────────────────────────────────────────────────────────────────────┐
│                           Users                                          │
├────────────────┬──────────────────┬────────────┬───────────┬────────────┤
│ User           │ Email            │ Phone      │ Role      │ Actions    │
├────────────────┼──────────────────┼────────────┼───────────┼────────────┤
│ 👤 Admin User  │ admin@email.com  │ 1234567890 │ 🔴 Admin  │ 👁️ ✏️ 🗑️   │
│ 👤 Order Taker │ order@email.com  │ 0987654321 │ 🔵 Order  │ 👁️ ✏️ 🗑️   │
│ 👤 Support     │ support@mail.com │ 1122334455 │ 🟡 Support│ 👁️ ✏️ 🗑️   │
│ 👤 John Doe    │ john@email.com   │ 5566778899 │ ⚫ User   │ 👁️ ✏️ 🗑️   │
└────────────────┴──────────────────┴────────────┴───────────┴────────────┘
                                                      ↑
                                              NEW ROLE COLUMN
```

## 📋 Permission Matrix

| Feature                  | Admin | Order Taker | Support | User |
|-------------------------|-------|-------------|---------|------|
| Dashboard               | ✅    | ✅          | ✅      | ✅   |
| Categories              | ✅    | ❌          | ❌      | ❌   |
| Products                | ✅    | ❌          | ❌      | ❌   |
| Users                   | ✅    | ❌          | ❌      | ❌   |
| Levels                  | ✅    | ❌          | ❌      | ❌   |
| **Orders**              | ✅    | ✅          | ✅      | ✅   |
| News                    | ✅    | ❌          | ❌      | ❌   |
| Suggestions             | ✅    | ❌          | ❌      | ❌   |
| Blog Categories         | ✅    | ❌          | ❌      | ❌   |
| Blog Posts              | ✅    | ❌          | ❌      | ❌   |
| Banners                 | ✅    | ❌          | ❌      | ❌   |
| Courier Services        | ✅    | ❌          | ❌      | ❌   |
| **Shipments**           | ✅    | ✅          | ✅      | ❌   |
| **Shipment Dashboard**  | ✅    | ✅          | ✅      | ❌   |

## 🔄 User Workflow

### Admin User Workflow
```
Login → Dashboard → Access ANY Module → Perform Actions → Logout
```

### Order Taker User Workflow
```
Login → Dashboard → Orders OR Shipments → Perform Actions → Logout
                     ↑
              (Limited to these only)
```

## 🎪 Role Badge Colors

```css
┌─────────────────────────────────────────────────────────────┐
│  ROLE BADGES IN USERS TABLE                                 │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  🔴 Admin        → bg-red-100    text-red-800               │
│  🔵 Order Taker  → bg-blue-100   text-blue-800              │
│  🟡 Support      → bg-yellow-100 text-yellow-800            │
│  ⚫ User         → bg-gray-100   text-gray-800              │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 🚀 Implementation Timeline

```
Day 1: Setup
├─ Run seeder (create roles)
├─ Run migration (sample user)
└─ Clear cache

Day 2: Create Order Taker Users
├─ Admin creates order_taker accounts
├─ Assign to staff members
└─ Provide credentials

Day 3: Training
├─ Train order_taker staff
├─ Document workflows
└─ Monitor usage

Day 4+: Operation
├─ Order takers use the system
├─ Monitor for issues
└─ Gather feedback
```

## 📊 System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                      WEB REQUEST                             │
└──────────────────────────┬──────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   AUTHENTICATION                             │
│                   (Is user logged in?)                       │
└──────────────────────────┬──────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                  ROLE MIDDLEWARE                             │
│              (Does user have required role?)                 │
└──────────────────────────┬──────────────────────────────────┘
                           │
                    ┌──────┴──────┐
                    │             │
                   YES           NO
                    │             │
                    ▼             ▼
         ┌──────────────┐  ┌──────────────┐
         │ ALLOW ACCESS │  │ 403 FORBIDDEN│
         └──────┬───────┘  └──────────────┘
                │
                ▼
         ┌──────────────┐
         │  CONTROLLER  │
         └──────┬───────┘
                │
                ▼
         ┌──────────────┐
         │     VIEW     │
         └──────┬───────┘
                │
                ▼
         ┌──────────────┐
         │  SIDEBAR     │
         │(Role-based)  │
         └──────────────┘
```

## 🎓 Best Practices

### DO ✅
- Always assign a role when creating users
- Use the role dropdown in forms
- Test with different roles after deployment
- Clear cache after seeder/migration
- Document custom permissions if added

### DON'T ❌
- Don't leave users without roles
- Don't manually edit database for roles
- Don't skip the seeder step
- Don't delete your own admin account
- Don't bypass role checks in code

## 📈 Scalability

The system is designed to scale:

1. **Add More Roles:** Create new roles in seeder
2. **Add Permissions:** Define granular permissions
3. **Custom Access:** Override permissions per user
4. **Audit Logs:** Track actions by role
5. **API Access:** Extend to API routes

---

**Visual guides help understand the system better!**
Refer to the detailed documentation files for more information.
