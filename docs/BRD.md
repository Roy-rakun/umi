1. WORKFLOW SISTEM AFFILIASI (End-to-End)
text
Affiliate Login/Register → Dashboard Affiliate → Pilih Produk → Generate Link → Bagikan Link
↓
Visitor Klik Link → Simpan Cookie (30 hari) → Checkout → Payment → Callback PAID
↓
Hitung Komisi → Status PENDING → Admin Review → Approve/Reject → Payout
Flow Detail:

Affiliate Flow:

Registrasi/Autentikasi

Akses dashboard

Pilih produk, generate link tracking

Pantau komisi & performa

Visitor/Buyer Flow:

Klik link affiliate

Redirect ke produk dengan tracking parameter

Checkout & pembayaran

Payment gateway callback

Admin Flow:

Monitoring order & komisi

Approve/reject komisi

Payout management

Fraud detection & handling

2. PRODUCT REQUIREMENTS DOCUMENT (PRD)
A. Overview
Nama Produk: Sistem Afiliasi "The Secret"

Platform: Web-based (Laravel), API-ready for mobile

Target Users: Affiliate, Admin, Buyer

Tech Stack: Laravel 10+, MySQL, REST API, JWT Auth

B. Fitur Utama
1. Authentication System
Registrasi affiliate dengan validasi email

Login dengan JWT token

Password reset

Role-based access (Affiliate/Admin)

2. Product Management
CRUD produk

Kategori produk (Kelas, Parfum, Event)

Harga normal & promo

Komisi rules per produk

3. Affiliate System
Generate unique tracking link

Cookie tracking (30 days)

Session management

Link performance analytics

4. Order & Payment
Checkout process

Payment gateway integration

Callback handler

Order status management

5. Commission System
Automatic commission calculation

Commission status (PENDING/APPROVED/PAID/REJECTED)

Payout management

Commission reports

6. Admin Dashboard
Real-time monitoring

Commission approval

Fraud detection alerts

User management

7. Anti-Fraud System
Self-order detection

IP/Device fingerprint validation

Rate limiting

Anomaly detection

C. Non-Functional Requirements
Performance: <2s page load, handle 1000+ concurrent users

Security: JWT, HTTPS, SQL injection prevention, XSS protection

Scalability: Modular architecture, API-first design

UI/UX: Clean, responsive, Sans-serif font family

3. BUSINESS REQUIREMENTS DOCUMENT (BRD)
A. Business Objectives
Meningkatkan penjualan melalui jaringan affiliate

Otomatisasi proses komisi & payout

Mencegah fraud & penyalahgunaan sistem

Memberikan transparansi ke affiliate

B. Stakeholders
Founder (@umyfadillaa) - Owner & decision maker

Affiliate - Promotor produk

Admin - System operator

Buyer - End customer

Developer - System builder & maintainer

C. Success Metrics
Conversion rate affiliate links

Total komisi dibayarkan

Jumlah affiliate aktif

Fraud prevention rate

System uptime (>99.5%)

D. Compliance Requirements
Privacy Policy compliance

Affiliate agreement legally binding

Financial transaction records

Tax reporting capability

4. ENTITY RELATIONSHIP DIAGRAM (ERD)
sql
-- USERS & AUTHENTICATION
users
├── id (PK)
├── name
├── email (unique)
├── password
├── phone
├── role (admin/affiliate)
├── affiliate_id (nullable)
├── bank_account
├── status (active/inactive)
└── timestamps

affiliates
├── affiliate_id (PK)
├── user_id (FK → users.id)
├── level (inner/outer)
├── total_commission
├── total_payout
├── referral_code
└── timestamps

-- PRODUCTS
products
├── product_id (PK)
├── name
├── description
├── category
├── price
├── promo_price
├── commission_inner
├── commission_outer
└── timestamps

-- TRACKING & ORDERS
affiliate_links
├── id (PK)
├── affiliate_id (FK → affiliates.affiliate_id)
├── product_id (FK → products.product_id)
├── tracking_code
├── clicks
├── conversions
└── timestamps

orders
├── order_id (PK)
├── product_id (FK → products.product_id)
├── affiliate_ref (nullable)
├── buyer_name
├── buyer_email
├── buyer_phone
├── amount
├── payment_status (pending/paid/failed)
├── ip_address
├── device_fingerprint
└── timestamps

-- COMMISSIONS & PAYOUT
commissions
├── commission_id (PK)
├── order_id (FK → orders.order_id)
├── affiliate_id (FK → affiliates.affiliate_id)
├── product_id (FK → products.product_id)
├── commission_amount
├── status (pending/approved/paid/rejected)
├── rejection_reason
└── timestamps

payouts
├── payout_id (PK)
├── affiliate_id (FK → affiliates.affiliate_id)
├── total_amount
├── status (pending/processed)
├── payment_proof
└── timestamps

-- FRAUD DETECTION
fraud_logs
├── id (PK)
├── affiliate_id (FK → affiliates.affiliate_id)
├── order_id (FK → orders.order_id)
├── fraud_type (self_order/fake_traffic/etc)
├── evidence_data (JSON)
├── action_taken
└── timestamps
5. BUSINESS MODEL ARCHITECTURE DOCUMENT (BMAD)
A. Architecture Pattern
text
Laravel MVC Architecture:
├── Presentation Layer (Blade Templates/API)
├── Business Logic Layer (Controllers/Services)
├── Data Access Layer (Models/Repositories)
└── Database Layer (MySQL)
B. API Specification (RESTful JSON)
Authentication API
php
// routes/api.php
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/auth/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
Affiliate API
php
// Product Endpoints
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Affiliate Link Generation
Route::post('/affiliate/link/generate', [AffiliateController::class, 'generateLink'])
    ->middleware('auth:api');

// Commission Tracking
Route::get('/affiliate/commissions', [CommissionController::class, 'index'])
    ->middleware('auth:api');
Route::get('/affiliate/dashboard', [DashboardController::class, 'affiliate'])
    ->middleware('auth:api');
Order API
php
Route::post('/orders/create', [OrderController::class, 'store']);
Route::post('/payment/callback', [PaymentController::class, 'callback']);
Admin API
php
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/admin/commissions/approve', [AdminController::class, 'approveCommission']);
    Route::post('/admin/commissions/reject', [AdminController::class, 'rejectCommission']);
    Route::post('/admin/payouts/create', [AdminController::class, 'createPayout']);
    Route::get('/admin/reports/sales', [ReportController::class, 'salesReport']);
});
C. Database Migration Examples
php
// users table migration
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->enum('role', ['admin', 'affiliate'])->default('affiliate');
    $table->string('affiliate_id')->nullable();
    $table->string('phone')->nullable();
    $table->text('bank_account')->nullable();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->rememberToken();
    $table->timestamps();
});

// commissions table migration
Schema::create('commissions', function (Blueprint $table) {
    $table->string('commission_id')->primary();
    $table->foreignId('order_id')->constrained('orders');
    $table->foreignId('affiliate_id')->constrained('affiliates');
    $table->foreignId('product_id')->constrained('products');
    $table->decimal('commission_amount', 12, 2);
    $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
    $table->text('rejection_reason')->nullable();
    $table->timestamps();
    
    $table->index(['affiliate_id', 'status']);
});
D. Service Layer Example
php
// App/Services/CommissionService.php
class CommissionService
{
    public function calculateCommission($orderId)
    {
        $order = Order::with('product', 'affiliate')->find($orderId);
        
        // Check for self-order fraud
        if ($this->isSelfOrder($order)) {
            return [
                'status' => 'rejected',
                'commission' => 0,
                'reason' => 'self_order_detected'
            ];
        }
        
        // Get commission based on affiliate level
        $affiliateLevel = $order->affiliate->level;
        $commissionAmount = ($affiliateLevel === 'inner') 
            ? $order->product->commission_inner
            : $order->product->commission_outer;
        
        return [
            'status' => 'pending',
            'commission' => $commissionAmount
        ];
    }
    
    private function isSelfOrder($order)
    {
        $affiliate = $order->affiliate;
        return $order->buyer_email === $affiliate->user->email 
            || $order->buyer_phone === $affiliate->user->phone;
    }
}
E. UI/UX Guidelines
Font Family: 'Inter', 'Segoe UI', 'Roboto', sans-serif (fallback: Arial)

Color Scheme:

Primary: #4F46E5 (Indigo)

Success: #10B981 (Emerald)

Warning: #F59E0B (Amber)

Danger: #EF4444 (Red)

Layout: Responsive, mobile-first approach

Components: Tailwind CSS or Bootstrap 5

F. Mobile App API Ready Features
Authentication Endpoints (JWT compatible)

Push Notification Support (FCM/APNS)

Deep Linking for affiliate links

Biometric Authentication option

Offline Caching for commission data

Image Upload for payout proof

G. Deployment Architecture
text
Load Balancer → Web Server (Nginx) → Laravel Application → MySQL Database
                              ↓
                    Redis (Cache & Session)
                              ↓
                    Cloud Storage (Files)
H. Security Measures
JWT Authentication with refresh tokens

Rate Limiting per endpoint

SQL Injection Prevention (Eloquent ORM)

XSS Protection (Blade templating)

CSRF Protection for web routes

Input Validation using Form Requests

CORS Configuration for API

HTTPS Enforcement

I. Monitoring & Logging
Error Tracking: Sentry/Laravel Telescope

Performance Monitoring: Laravel Debugbar

Access Logs: Nginx/Laravel Logs

Business Metrics: Custom dashboard

6. IMPLEMENTATION TIMELINE
Phase 1 (Week 1-2): Core System

Authentication & User Management

Product & Commission Structure

Basic Affiliate Dashboard

Phase 2 (Week 3-4): Transaction Flow

Order Processing

Payment Integration

Commission Calculation

Phase 3 (Week 5-6): Admin & Reporting

Admin Dashboard

Fraud Detection

Reporting System

Phase 4 (Week 7-8): Optimization & Mobile API

API Optimization

Mobile App Endpoints

Performance Tuning

7. TESTING STRATEGY
Unit Testing: PHPUnit for business logic

Feature Testing: Laravel Dusk for workflows

API Testing: Postman/Insomnia collections

Security Testing: OWASP ZAP scanning

Performance Testing: Load testing with JMeter

Catatan Teknis Tambahan:

Database indexing untuk query performa

Queue system untuk email & notification

Event-driven architecture untuk extensibility

API versioning untuk backward compatibility

Documentation dengan Swagger/OpenAPI

Dokumen ini siap untuk diimplementasikan dengan Laravel dan dapat diskalakan untuk mendukung aplikasi mobile di masa depan. Semua endpoint API sudah dirancang dengan konsep RESTful dan siap untuk integrasi dengan berbagai frontend framework.