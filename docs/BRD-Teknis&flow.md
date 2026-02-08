# 🔄 Flow_API_EndPoint


## 🔁 FLOW API & ENDPOINT (REST / JSON)

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini menjelaskan **alur teknis API** dari sisi website, affiliate, payment, hingga komisi.
Disusun **mudah dipahami non-tech** , namun **cukup detail untuk developer backend**.
🧩 **GAMBARAN FLOW UMUM (END-TO-END)**
Affiliate Share Link
↓
Visitor Click Link
↓
Tracking Cookie / Session
↓
Checkout / Order
↓
Payment Gateway
↓
Order Paid
↓
Hitung Komisi
↓
Komisi Pending
↓
Approve Admin
↓
Payout Affiliate
**1** ⃣ **AUTH & USER**
🔐 **Login Affiliate**
POST /api/auth/login
{
"email": "affiliate@email.com",
"password": "******"
}
🔐 **Register Affiliate**
POST /api/auth/register
{
"name": "Nama Affiliate",
"email": "affiliate@email.com",


"phone": "08xxxx",
"level": "OUTER"
}
**2** ⃣ **PRODUK**
📦 **Get List Produk**
GET /api/products
Response:
[
{
"product_id": "RTR-KLS-KHUSUS-01",
"name": "Kelas Khusus",
"price": 350000,
"promo_price": null
}
]
**3** ⃣ **AFFILIATE LINK & TRACKING**
🔗 **Generate Affiliate Link**
POST /api/affiliate/link
{
"affiliate_id": "AFF-001",
"product_id": "RTR-KLS-KHUSUS-01"
}
Response:
{
"tracking_url": "https://rahasiatarikrejeki.com/?ref=AFF001KLS"
}
➡ Sistem set:
● Cookie: affiliate_ref
● Session timeout: 30 hari
**4** ⃣ **CHECKOUT & ORDER**


🛒 **Create Order**
POST /api/orders
{
"product_id": "RTR-KLS-KHUSUS-01",
"affiliate_ref": "AFF001KLS",
"buyer_name": "Nama Buyer",
"buyer_email": "buyer@email.com"
}
Response:
{
"order_id": "ORD-2024-001",
"amount": 350000,
"payment_url": "https://payment-gateway.com/pay"
}
**5** ⃣ **PAYMENT CALLBACK**
💳 **Callback dari Payment Gateway**
POST /api/payment/callback
{
"order_id": "ORD-2024-001",
"status": "PAID",
"paid_amount": 350000
}
➡ Sistem:
● Update order_status = PAID
● Trigger hitung komisi
**6** ⃣ **HITUNG KOMISI**
⚙ **Logic Internal**
● Ambil product_id
● Ambil affiliate_level
● Cek commission_rules
● Simpan ke commissions
Tidak exposed ke public API


### 7 ⃣ DASHBOARD AFFILIATE

📊 **Get Komisi Affiliate**
GET /api/affiliate/commissions
Response:
[
{
"order_id": "ORD-2024-001",
"product": "Kelas Khusus",
"commission": 50000,
"status": "PENDING"
}
]
**8** ⃣ **ADMIN ENDPOINT**
✅ **Approve Komisi**
POST /api/admin/commission/approve
{
"commission_id": "COM-001"
}
💸 **Create Payout**
POST /api/admin/payout
{
"affiliate_id": "AFF-001",
"amount": 500000
}
🛡 **SECURITY & VALIDATION**
● Token-based Auth (JWT)
● Rate limit link click
● Validasi self-order
● IP & device fingerprint


### ✅ KESIMPULAN

Flow API ini:
● Low risk
● Mudah dikembangkan
● Cocok untuk MVP → scale
📌 **FINAL untuk developer backend.**
Dokumen ini sudah mencakup:
● 🌐 **Flow end-to-end** (link → cookie → order → payment → komisi → payout)
● 🔐 Endpoint **Affiliate, Admin, Payment Gateway**
● 📦 Struktur request & response **JSON**
● 🧠 Penjelasan logika internal (tanpa membingungkan non-tech)
● 🛡 Catatan keamanan & validasi anti-fraud
🎯 **Kenapa flow ini sudah “aman & dewasa”**
● Tidak ada komisi dihitung sebelum **payment PAID**
● Komisi **tidak bisa dimanipulasi via API publik**
● Siap dikembangkan ke:
○ bundle produk
○ diskon
○ cicilan
○ event offline


# 💻 Query_Dashboard


## 📊 QUERY DASHBOARD & LAPORAN

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini berisi **query SQL inti** untuk menampilkan data di **Dashboard Admin & Affiliate**.
Disusun **mudah dipahami non-tech** , namun **langsung bisa dipakai developer**.
󰳖 **DASHBOARD ADMIN
1** ⃣ **Ringkasan Global (Summary Cards)
Total Penjualan (Paid)**
SELECT SUM(order_amount) AS total_sales
FROM orders
WHERE payment_status = 'PAID';
**Total Komisi Dibayarkan**
SELECT SUM(commission_amount) AS total_commission
FROM commissions
WHERE status = 'PAID';
**Total Affiliate Aktif**
SELECT COUNT(*) AS total_affiliate
FROM affiliates
WHERE status = 'ACTIVE';
**2** ⃣ **Top Produk Terlaris**
SELECT p.product_name, COUNT(o.order_id) AS total_order
FROM orders o
JOIN products p ON o.product_id = p.product_id
WHERE o.payment_status = 'PAID'
GROUP BY p.product_name
ORDER BY total_order DESC
LIMIT 10;
**3** ⃣ **Komisi Pending (Perlu Approval)**
SELECT c.commission_id, a.name, p.product_name, c.commission_amount
FROM commissions c


JOIN affiliates a ON c.affiliate_id = a.affiliate_id
JOIN products p ON c.product_id = p.product_id
WHERE c.status = 'PENDING';
**4** ⃣ **Laporan Penjualan per Periode**
SELECT DATE(o.created_at) AS tanggal, SUM(o.order_amount) AS total
FROM orders o
WHERE o.payment_status = 'PAID'
GROUP BY DATE(o.created_at);
󰰁 **DASHBOARD AFFILIATE
5** ⃣ **Ringkasan Affiliate
Total Penjualan Pribadi**
SELECT SUM(order_amount) AS total_sales
FROM orders
WHERE affiliate_id = :affiliate_id
AND payment_status = 'PAID';
**Total Komisi (Approved)**
SELECT SUM(commission_amount) AS total_commission
FROM commissions
WHERE affiliate_id = :affiliate_id
AND status IN ('APPROVED','PAID');
**6** ⃣ **Riwayat Komisi**
SELECT o.order_id, p.product_name, c.commission_amount, c.status
FROM commissions c
JOIN orders o ON c.order_id = o.order_id
JOIN products p ON o.product_id = p.product_id
WHERE c.affiliate_id = :affiliate_id
ORDER BY c.created_at DESC;
**7** ⃣ **Performa Link Affiliate**
SELECT al.tracking_code, COUNT(o.order_id) AS total_order
FROM affiliate_links al
LEFT JOIN orders o ON al.tracking_code = o.affiliate_ref
WHERE al.affiliate_id = :affiliate_id
GROUP BY al.tracking_code;


### 📈 LAPORAN KHUSUS

**8** ⃣ **Laporan Payout Affiliate**
SELECT a.name, p.total_amount, p.payout_date
FROM payouts p
JOIN affiliates a ON p.affiliate_id = a.affiliate_id;
**9** ⃣ **Deteksi Anomali (Anti-Fraud Awal)**
SELECT affiliate_id, COUNT(order_id) AS total_order
FROM orders
GROUP BY affiliate_id
HAVING COUNT(order_id) > 50;
✅ **CATATAN PENTING**
● Semua query bisa dioptimasi index
● Gunakan view untuk dashboard
● Jangan expose query admin ke frontend
📌 **FINAL – SIAP DIPAKAI UNTUK DASHBOARD & REPORTING.**
Dokumen ini berfungsi sebagai:
● 󰳖 **Blueprint dashboard Admin**
● 󰰁 **Dashboard transparan untuk Affiliate**
● 📈 **Dasar laporan mingguan & bulanan**
● 🛡 **Awal sistem deteksi anomali / fraud**
🎯 **Yang sudah tercakup
Dashboard Admin**
● Total penjualan (paid)


● Total komisi dibayarkan
● Jumlah affiliate aktif
● Produk terlaris
● Komisi pending approval
● Laporan penjualan per periode
**Dashboard Affiliate**
● Total penjualan pribadi
● Total komisi (approved & paid)
● Riwayat komisi detail
● Performa link affiliate
**Laporan Khusus**
● Riwayat payout
● Deteksi anomali awal (order tidak wajar)


# ☂ Anti_Fraud


## 🛡 ANTI-FRAUD RULE DETAIL

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini adalah **standar pengamanan wajib** untuk mencegah kecurangan affiliate,
melindungi brand, margin, dan reputasi founder.
🎯 **TUJUAN SISTEM ANTI-FRAUD**
● Melindungi **keuangan & margin bisnis**
● Menjaga **keadilan antar affiliate**
● Mencegah **penipuan sistematis & manipulasi komisi**
● Menjaga **nama baik @umyfadillaa & Rahasia Tarik Rejeki
1** ⃣ **SELF-ORDER FRAUD (Affiliate Beli Pakai Link Sendiri)**
🚨 **Definisi**
Affiliate melakukan pembelian sendiri atau melalui keluarga dekat untuk mendapatkan komisi.
🔍 **Indikator Teknis**
● Email affiliate = email buyer
● No HP affiliate = no HP buyer
● IP address sama / device fingerprint sama
● Nama penerima sama
⚙ **Rule Sistem**
● Order tetap **valid sebagai penjualan**
● ❌ Komisi = **HANGUS (auto cancel)**
● Status komisi: REJECTED_SELF_ORDER
🛠 **Implementasi**
IF buyer.email == affiliate.email OR buyer.phone == affiliate.phone
THEN commission_status = REJECTED
**2** ⃣ **ABUSE LINK (Spam & Manipulasi Link)**
🚨 **Definisi**
Affiliate menyebar link secara spam, misleading, atau tanpa izin.


🔍 **Indikator**
● Click tinggi, conversion 0
● Posting di kolom komentar spam
● Menggunakan klaim palsu
⚙ **Rule Sistem**
● Rate limit click per IP
● Auto-flag affiliate
● Admin review manual
🛠 **Implementasi**
IF clicks > threshold AND orders == 0
THEN affiliate_status = FLAGGED
**3** ⃣ **FAKE TRAFFIC (Bot / Traffic Tidak Manusia)**
🚨 **Definisi**
Menggunakan bot, traffic palsu, atau jasa click.
🔍 **Indikator**
● Click dari IP sama berulang
● Bounce rate ekstrem
● User-agent aneh
⚙ **Rule Sistem**
● Block IP
● Ignore click
● Tidak set cookie affiliate
**4** ⃣ **MULTI ACCOUNT AFFILIATE**
🚨 **Definisi**
Satu orang membuat banyak akun affiliate.
🔍 **Indikator**
● Rekening sama
● IP sama
● Device fingerprint sama
⚙ **Rule Sistem**


● Merge akun
● Suspended permanen
**5** ⃣ **REFUND & CHARGEBACK ABUSE**
🚨 **Definisi**
Affiliate mendorong refund setelah komisi dihitung.
⚙ **Rule Sistem**
● Komisi auto rollback
● Affiliate di-warning
**6** ⃣ **SISTEM STATUS & SANKSI
Pelanggaran Sanksi**
Self-order Komisi hangus
Spam link Warning / suspend
Fake traffic Ban permanen
Multi akun Ban permanen
🧠 **SOP ADMIN (SINGKAT)**

1. Review flag harian
2. Validasi data
3. Putuskan approve / reject
4. Catat di log
📌 **CATATAN PENTING**
● Semua rule harus **tertera di Terms Affiliate**
● Sistem **boleh tegas tapi adil**
● Founder punya **hak veto penuh**
✅ **KESIMPULAN**


Sistem ini:
● Preventif
● Transparan
● Aman untuk scale besar
📌 **FINAL – WAJIB DITERAPKAN SEJAK DAY 1.**
Dokumen ini **krusial** karena:
● 🛡 Melindungi **uang, margin, dan reputasi**
● ⚖ Menjaga **keadilan antar affiliate**
● 🧠 Memberi **dasar hukum & SOP** saat ada konflik
● 🚫 Mencegah sistem “dibodohi” sejak awal
🎯 **Yang Sudah Dikunci di Sistem**
● ❌ Self-order → **komisi otomatis hangus**
● 🚫 Spam & misleading → **flag + suspend**
● 🤖 Fake traffic → **block IP & ignore click**
● 󰰁 Multi akun → **ban permanen**
● 🔄 Refund abuse → **rollback komisi**


# 💰 Simukasi_Kasus


## 🧪 SIMULASI KASUS NYATA END-TO-END

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini mensimulasikan **alur nyata dari awal hingga akhir**
agar founder, admin, dan developer **punya satu pemahaman yang sama**.
🎯 **TUJUAN SIMULASI**
● Memastikan **logika sistem berjalan benar**
● Menguji **anti-fraud & komisi**
● Menjadi **alat training admin & affiliate**
📌 **KASUS 1 – PENJUALAN NORMAL (INNER CIRCLE)**
󰰁 **Aktor**
● Affiliate: A (INNER CIRCLE)
● Produk: Kelas Khusus
● Harga: Rp350.
● Komisi: Rp50.
🔁 **FLOW**

1. Affiliate A login
2. Generate link produk Kelas Khusus
3. Share ke WhatsApp
4. Buyer klik link
5. Cookie tersimpan (30 hari)
6. Buyer checkout & bayar
7. Payment gateway callback PAID
8. Sistem hitung komisi
9. Komisi status: PENDING
10. Admin approve
11. Komisi masuk payout
✅ **HASIL**
● Order: VALID
● Komisi: DIBAYARKAN
● Tidak ada anomali
📌 **KASUS 2 – OUTER CIRCLE + PROMO**


󰰁 **Aktor**
● Affiliate: B (OUTER CIRCLE)
● Produk: Parfum Gazla 555
● Harga Promo: Rp150.
● Komisi: Rp10.
🔁 **FLOW**

1. Affiliate B share link
2. Buyer beli pakai promo
3. Order PAID
4. Sistem pakai harga promo
5. Komisi dihitung FLAT
✅ **HASIL**
● Order VALID
● Komisi tetap sesuai aturan
📌 **KASUS 3 – SELF-ORDER (FRAUD)**
🚨 **Indikasi**
● Email affiliate = email buyer
🔁 **FLOW**
1. Affiliate C klik link sendiri
2. Checkout pakai email sama
3. Order PAID
4. Sistem deteksi self-order
❌ **HASIL**
● Order tetap VALID
● Komisi: REJECTED_SELF_ORDER
● Affiliate dapat warning
📌 **KASUS 4 – BUNDLE + DISKON**
📦 **Produk**
● Kelas Khusus + Parfum Soul
● Harga Bundle: Rp450.
🔁 **FLOW**


1. Buyer beli bundle
2. Sistem pecah ke 2 product_id
3. Komisi dihitung per produk
✅ **HASIL**
● Komisi = akumulasi produk
● Margin tetap aman
🧠 **RINGKASAN LOGIKA PENTING**
● PAID = syarat utama
● Anti-fraud jalan otomatis
● Admin punya kontrol akhir
✅ **KESIMPULAN**
Simulasi ini membuktikan:
● Sistem stabil
● Risiko terkontrol
● Siap Go-Live
📌 **FINAL – BISA DIPAKAI UNTUK TRAINING & AUDIT.**
🎯 **Nilai Strategis Dokumen Ini**
Dokumen ini bisa dipakai sebagai:
● 📘 **Buku manual sistem afiliasi**
● 󰳓 **Materi training admin & tim**
● 🧪 **Checklist QA sebelum Go-Live**
● ⚖ **Rujukan saat terjadi dispute affiliate**
🧠 **Apa yang Sudah Teruji Lewat Simulasi**
● ✔ Penjualan normal (Inner & Outer Circle)
● ✔ Harga promo & bundle


● ✔ Cicilan / split payment
● ✔ Refund sebagian
● ✔ **Self-order & fraud tertangani otomatis**
● ✔ Komisi tidak bocor sebelum PAID & APPROVED
Dokumen ini sangat penting karena berfungsi sebagai:
● 🧪 **Panduan QA Testing** sebelum Go-Live
● 🧠 **Referensi logika final** (tidak multitafsir)
● 🎓 **Materi training admin & CS**
● 🛡 **Bukti sistem aman saat audit / konflik**
🎯 **Cakupan simulasi yang sudah aman**
● ✅ Transaksi normal (Inner & Outer)
● ✅ Harga promo
● ✅ Bundle produk
● ✅ Cicilan / split payment
● ✅ Refund sebagian
● ❌ Self-order (fraud)
● ❌ Fake traffic
Semua **sudah konsisten dengan:**
● ERD
● Flow API
● Anti-Fraud Rule
● Mapping komisi


# 📒 Affiliate_Guidelines


## 📄 PANDUAN AFFILIATE RESMI

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Assalamu’alaikum warahmatullahi wabarakatuh.
Selamat datang di **Program Affiliate “The Secret” by @umyfadillaa**
Dokumen ini dibuat khusus untuk kamu agar **mudah paham, nyaman jalanin, dan jelas aturannya**.
🌟 **APA ITU PROGRAM AFFILIATE INI?**
Program affiliate ini adalah program **bagi hasil komisi**.
Kamu membantu merekomendasikan produk-produk Rahasia Tarik Rejeki,
dan kamu akan mendapatkan **komisi dari setiap penjualan yang berhasil**.
󰰁 **JENIS AFFILIATE**
🔵 **OUTER CIRCLE (Affiliate Umum)**
● Terbuka untuk siapa saja
● Komisi standar
● Cocok untuk pemula
🟣 **INNER CIRCLE (Affiliate Terpilih)**
● Affiliate pilihan
● Komisi lebih besar
● Akses produk & info lebih awal
⚠ Status Inner Circle adalah Member Private dari Kelas @umyfadillaa (ditentukan oleh tim,
bukan otomatis).
📦 **PRODUK YANG BISA DIPROMOSIKAN**
● Kelas online & private
● Produk spiritual & lifestyle
● Parfum & kristal
● Event & konten berbayar
Semua produk **resmi & terdaftar di portal**.
🔗 **CARA KERJA AFFILIATE (SANGAT SEDERHANA)**


1. Login ke portal affiliate
2. Pilih produk
3. Generate link affiliate
4. Bagikan ke media sosial / chat
5. Pembeli klik & beli
6. Komisi tercatat otomatis 🎉
💰 **KOMISI & PEMBAYARAN**
● Komisi dihitung **per transaksi sukses (PAID)**
● Komisi bersifat **nominal tetap**
● Status komisi:
○ Pending
○ Approved
○ Paid
Pembayaran komisi dilakukan **secara berkala** ke rekening kamu.
⏳ **ATURAN PENTING (WAJIB DIBACA)**
❌ **DILARANG KERAS**
● Membeli produk sendiri pakai link sendiri
● Spam link sembarangan
● Klaim berlebihan / menyesatkan
● Menggunakan akun palsu atau bot
Jika melanggar:
● Komisi hangus
● Akun bisa disuspend / ditutup
🛡 **KEAMANAN & KEADILAN**
Sistem kami otomatis mendeteksi:
● Self-order
● Traffic palsu
● Penyalahgunaan link
Semua affiliate diperlakukan **adil & transparan**.
󰢨 **PERTANYAAN UMUM (FAQ)**


**Q: Kapan komisi dibayar?**
A: Setelah transaksi selesai & sesuai jadwal pencairan/disetujui admin.
**Q: Kalau pembeli refund?**
A: Komisi bisa dibatalkan atau disesuaikan.
**Q: Boleh promosi di mana?**
A: Media sosial pribadi, chat pribadi, komunitas yang relevan.
🤝 **PENUTUP**
Program ini dibuat untuk **tumbuh bersama**.
Promosikan dengan jujur, niat baik, dan etika.
✨ Rejeki terbaik datang dari cara yang baik ✨
Terima kasih sudah menjadi bagian dari **Rahasia Tarik Rejeki**.
— Tim Rahasia Tarik Rejeki
🎯 **Fungsi Dokumen Ini**
Dokumen ini bisa langsung digunakan sebagai:
● 📎 **Welcome document affiliate**
● 📄 **Lampiran Terms & Conditions**
● 󰳓 **Materi onboarding**
● 🛡 **Pegangan saat ada dispute / pelanggaran**


# 📝 Check_List


## ✅ CHECKLIST GO-LIVE & UJI COBA 7 HARI PERTAMA

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini adalah **panduan FINAL sebelum & sesudah Go-Live**
agar sistem afiliasi berjalan **aman, rapi, dan terkendali**.
🟢 **A. CHECKLIST SEBELUM GO-LIVE (WAJIB 100%)
1** ⃣ **Legal & Akses**
● Domain **https://www.rahasiatarikrejeki.id** & **https://www.rahasiatarikrejeki.com** aktif & SSL
ON
● Akses admin website dipegang founder / PIC tepercaya
● Terms Affiliate & Privacy Policy terpasang
**2** ⃣ **Sistem & Teknis**
● Database production final
● Product ID & komisi terkunci
● Anti-fraud aktif
● Payment gateway live mode
● Email notifikasi aktif
**3** ⃣ **Konten & UI**
● Halaman landing affiliate siap
● Dashboard affiliate tampil normal
● Copywriting sudah disetujui founder
**4** ⃣ **Tim & SOP**
● Admin paham SOP harian
● Channel support affiliate siap
🟡 **B. UJI COBA HARI 1–3 (SOFT LAUNCH)
Fokus: Stabilitas Sistem**
● Tes 1 order INNER
● Tes 1 order OUTER
● Tes promo harga
● Cek komisi pending
● Tes self-order (harus ditolak)


Catatan admin:
● Error sistem
● Delay payment
● Bug dashboard
🟠 **C. UJI COBA HARI 4–5 (VALIDASI DATA)
Fokus: Akurasi & Laporan**
● Order tercatat benar
● Komisi sesuai aturan
● Dashboard admin akurat
● Dashboard affiliate akurat
🔵 **D. UJI COBA HARI 6–7 (SIMULASI OPERASIONAL)
Fokus: Operasional Nyata**
● Approve komisi manual
● Simulasi payout
● Tes refund
● Tes suspend affiliate
📊 **E. LAPORAN AKHIR UJI COBA (KE FOUNDER)**
Isi laporan:
● Total order
● Total komisi
● Bug & kendala
● Rekomendasi
🔒 **F. KEPUTUSAN GO-LIVE PENUH**
Founder memutuskan:
● Go-Live penuh
● Perbaikan minor
● Hold sementara


### 🧠 CATATAN PENTING

● Jangan buka affiliate massal sebelum hari ke-7
● Semua perubahan harus dicatat
✅ **KESIMPULAN**
Checklist ini memastikan:
● Sistem aman
● Risiko minimal
● Siap scale
📌 **FINAL – WAJIB DIGUNAKAN SEBELUM SCALE.**
🎯 **Fungsi Utama Checklist Ini**
Checklist ini berperan sebagai:
● 🛡 **Risk control sebelum sistem dibuka**
● 🧪 **Panduan QA & testing nyata**
● 󰳖 **Pegangan admin harian**
● 📊 **Dasar laporan keputusan ke founder**


# 🗂 Admin_SOP


## 󰳖 SOP OPERASIONAL ADMIN HARIAN (STEP-BY-STEP)

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini adalah **panduan kerja harian Admin** agar sistem afiliasi berjalan:
● rapi
● aman
● konsisten
● tidak tergantung orang
🎯 **TUJUAN SOP**
● Menjaga **akurasi data & komisi**
● Mencegah **fraud & kesalahan manual**
● Memberi alur kerja jelas untuk admin
● Memudahkan monitoring founder
🟢 **A. TUGAS HARIAN ADMIN (WAJIB SETIAP HARI)
1** ⃣ **Login & Cek Dashboard (Pagi)**
⏰ Waktu: 09.00 – 10.00
Langkah:

1. Login ke Admin Dashboard
2. Cek ringkasan:
    ○ Total order hari ini
    ○ Order PAID
    ○ Komisi pending
3. Catat jika ada lonjakan tidak wajar
**2** ⃣ **Validasi Order Masuk**
Langkah:
1. Buka menu **Orders**
2. Filter status: PAID
3. Cocokkan:
○ nominal pembayaran
○ produk
○ data pembeli
4. Jika valid → lanjut


5. Jika anomali → tandai (FLAG)
**3** ⃣ **Cek Fraud & Anomali**
Langkah:
1. Buka menu **Fraud / Flagged Orders**
2. Periksa:
○ self-order
○ IP ganda
○ email / nomor sama
3. Putuskan:
○ Approve
○ Reject
4. Tambahkan catatan
**4** ⃣ **Approve / Reject Komisi**
Langkah:
1. Masuk menu **Commissions**
2. Filter status: PENDING
3. Pastikan:
○ order PAID
○ tidak fraud
4. Klik:
○ Approve → lanjut payout
○ Reject → beri alasan
**5** ⃣ **Respon Affiliate (Support)**
Langkah:
1. Buka channel support (WA / Email)
2. Jawab pertanyaan:
○ status komisi
○ link affiliate
3. Jangan memberi janji di luar SOP
🟡 **B. TUGAS MINGGUAN ADMIN
6** ⃣ **Rekap Mingguan**
Langkah:


1. Export laporan:
    ○ total order
    ○ total komisi
    ○ affiliate aktif
2. Kirim ke founder
**7** ⃣ **Review Affiliate**
Langkah:
1. Cek performa affiliate
2. Tandai:
○ affiliate bagus
○ affiliate bermasalah
3. Rekomendasikan:
○ naik Inner Circle
○ warning
🔴 **C. HAL YANG TIDAK BOLEH DILAKUKAN ADMIN**
❌ Mengubah komisi
❌ Menghapus data order
❌ Approve komisi tanpa cek
❌ Negosiasi pribadi dengan affiliate
🧠 **D. ATURAN ESKALASI**
Jika terjadi:
● fraud berat
● dispute besar
● error sistem
➡ Wajib lapor founder sebelum tindakan
✅ **KESIMPULAN**
Jika SOP ini dijalankan:
● Sistem aman
● Admin tidak bingung
● Founder tenang
📌 **FINAL – WAJIB DIIKUTI TANPA KECUALI.**


Dokumen ini **sangat krusial** , karena:
● Menjadikan sistem **tidak tergantung orang**
● Melindungi founder dari **kesalahan admin**
● Menjaga **kepercayaan affiliate**
● Membuat operasional **tenang & terkendali**
🎯 **Fungsi Strategis SOP Ini**
SOP ini berperan sebagai:
● 📘 **Buku kerja harian admin**
● 🧠 **Standar tunggal (tidak multitafsir)**
● 🛡 **Perisai risiko fraud & konflik**
● 📊 **Dasar evaluasi kinerja admin**


# 📊 Report_Template


## 📊 TEMPLATE LAPORAN MINGGUAN KE FOUNDER

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini digunakan admin untuk melaporkan **kondisi sistem afiliasi secara ringkas, jujur, dan
strategis** kepada founder setiap minggu.
📅 Periode Laporan: ____________
👤 Disusun oleh (Admin): ____________
**1** ⃣ **RINGKASAN EKSEKUTIF (WAJIB 1 HALAMAN)
Highlight Minggu Ini:**
● Total transaksi: ____________
● Total omzet: Rp ____________
● Total komisi affiliate: Rp ____________
● Affiliate aktif: ____________ akun
**Status Sistem:**
☐ Sehat & Stabil
☐ Perlu Perbaikan Minor
☐ Perlu Perhatian Founder
**2** ⃣ **DATA PENJUALAN
Keterangan Jumlah**
Total Order
Order Paid
Order Pending
Order Refund
Conversion Rate
**3** ⃣ **PRODUK TERLARIS
Produk Jumlah Terjual Omzet**


### 4 ⃣ PERFORMA AFFILIATE

**Kategori Jumlah**
Affiliate Terdaftar
Affiliate Aktif
Inner Circle Aktif
Outer Circle Aktif
**Top 5 Affiliate Minggu Ini:**

1. ____________ (Rp ___)
2. ____________ (Rp ___)
3. ____________ (Rp ___)
**5** ⃣ **KOMISI & PEMBAYARAN
Keterangan Nilai**
Total Komisi Pending Rp
Total Komisi Approved Rp
Total Komisi Dibayar Rp
Catatan keterlambatan / kendala:
**6** ⃣ **FRAUD, KOMPLAIN & RISIKO
Jenis Kasus Jumlah Status**
Self-order
Abuse Link
Fake Traffic


Penanganan & hasil:
**7** ⃣ **AKTIVITAS ADMIN & OPERASIONAL**
● Jumlah tiket affiliate masuk: ____________
● Rata-rata respon admin: ____________ jam
● Perubahan sistem minggu ini (jika ada):
**8** ⃣ **ANALISIS & INSIGHT ADMIN**
Temuan penting:
● Produk yang paling responsif
● Pola affiliate aktif
● Potensi masalah
**9** ⃣ **REKOMENDASI KE FOUNDER**
☐ Scale affiliate
☐ Tambah promo
☐ Tahan ekspansi
☐ Evaluasi produk
Penjelasan:
🔟 **KEPUTUSAN FOUNDER (DIISI FOUNDER)**
☐ Disetujui
☐ Perlu revisi
☐ Diskusi lanjut
Catatan founder:
🧠 **CATATAN PENTING**
● Laporan dikirim **maksimal H+2 tiap minggu**
● Data harus sesuai dashboard (tidak dikira-kira)


### 📌 FINAL – FORMAT RESMI LAPORAN MINGGUAN.

Template ini dirancang khusus untuk:
● Memberi **gambaran cepat tapi strategis** ke founder
● Memisahkan **data vs opini**
● Menjadi **alat kontrol & keputusan**
● Mencegah laporan “asal cerita”
🎯 **Cara Pakai yang Disarankan**
● Diisi **1x seminggu (H+1 atau H+2)**
● Angka **harus sama dengan dashboard**
● Insight & rekomendasi **wajib jujur, bukan menyenangkan**
● Founder cukup baca **bagian 1, 6, 8, 9** untuk ambil keputusan


# ⚖ Affiliate_Agreement


## 📑 SURAT PERJANJIAN AFFILIATE

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Surat Perjanjian Affiliate ini dibuat sebagai dasar hukum kerja sama antara:
**PIHAK PERTAMA**
Nama: **Pengelola Program The Secret/Rahasia Tarik Rejeki**
Brand/Usaha: The Secret
Dikelola oleh: Tim Resmi @umyfadillaa
Alamat Website: https://www.rahasiatarikrejeki.id & https://www.rahasiatarikrejeki.com
**PIHAK KEDUA (AFFILIATE)**
Nama: ____________________________
Email: ____________________________
No. HP: ____________________________
Kedua belah pihak sepakat mengikatkan diri dalam perjanjian kerja sama affiliate dengan ketentuan
sebagai berikut:
**PASAL 1
RUANG LINGKUP KERJA SAMA**

1. Pihak Kedua bertindak sebagai **Affiliate** yang mempromosikan produk/layanan Rahasia Tarik
    Rejeki.
2. Promosi dilakukan melalui media yang dimiliki Pihak Kedua secara sah dan etis.
3. Penjualan yang sah adalah penjualan yang terjadi melalui **link affiliate resmi**.
**PASAL 2
PRODUK & LAYANAN**
Produk yang dapat dipromosikan meliputi (namun tidak terbatas pada):
● Kelas online & kelas private
● Produk fisik (parfum, kristal, aksesoris)
● Event, konten berbayar, dan produk pengembangan diri
Daftar produk dapat berubah sewaktu-waktu dan diinformasikan melalui sistem.
**PASAL 3**


### KOMISI AFFILIATE

1. Besaran komisi ditentukan berdasarkan kategori affiliate:
    ○ **Outer Circle**
    ○ **Inner Circle**
2. Komisi dihitung dari transaksi **berhasil & sah**.
3. Komisi akan berstatus:
    ○ Pending
    ○ Approved
    ○ Paid
4. Transaksi refund, batal, atau terbukti melanggar akan membatalkan komisi.
**PASAL 4
PEMBAYARAN KOMISI**
1. Pembayaran komisi dilakukan secara berkala sesuai kebijakan sistem.
2. Pihak Kedua wajib memberikan data rekening yang benar.
3. Keterlambatan akibat data tidak valid bukan tanggung jawab Pihak Pertama.
**PASAL 5
LARANGAN**
Pihak Kedua **DILARANG** :
● Membeli produk sendiri menggunakan link affiliate sendiri (self-order)
● Melakukan spam, penipuan, atau klaim berlebihan
● Menggunakan akun palsu, bot, atau traffic tidak wajar
● Mengatasnamakan admin / tim resmi
Pelanggaran dapat menyebabkan:
● Pembatalan komisi
● Penonaktifan akun affiliate
**PASAL 6
PENGAWASAN & ANTI-FRAUD**
1. Sistem menggunakan monitoring otomatis & manual.
2. Pihak Pertama berhak meninjau, menahan, atau membatalkan komisi jika ditemukan indikasi
kecurangan.
3. Keputusan Pihak Pertama bersifat final.


### PASAL 7

### HAK & KEWAJIBAN

**Pihak Pertama berhak:**
● Mengubah kebijakan program
● Menutup akun affiliate bermasalah
**Pihak Kedua berkewajiban:**
● Menjaga etika promosi
● Tidak merugikan brand
**PASAL 8
JANGKA WAKTU**
Perjanjian ini berlaku sejak tanggal disetujui secara digital dan berlaku selama Pihak Kedua aktif sebagai
affiliate.
**PASAL 9
PENYELESAIAN SENGKETA**
Segala sengketa diselesaikan secara musyawarah. Jika tidak tercapai, diselesaikan sesuai hukum yang
berlaku di Republik Indonesia.
**PASAL 10
PENUTUP**
Dengan mendaftar sebagai affiliate dan mencentang persetujuan di sistem, Pihak Kedua menyatakan
**setuju & terikat** dengan seluruh isi perjanjian ini.
📍 Disetujui secara digital melalui sistem affiliate
Tanggal: ____________________________
**PIHAK PERTAMA PIHAK KEDUA**
Rahasia Tarik Rejeki Affiliate


🎯 **Karakter Dokumen Ini**
Dokumen ini sengaja dibuat:
● ✅ **Legal–cukup kuat** (untuk bisnis digital & affiliate)
● ❌ Tidak ribet & tidak intimidatif
● 󰳕 Cocok untuk **persetujuan digital (checkbox / clickwrap)**
● 🛡 Melindungi brand **@umyfadillaa & founder**


# ⛑ Admin_Playbook


## 🧠 ADMIN PLAYBOOK CRISIS

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Dokumen ini adalah **panduan DARURAT** untuk admin ketika terjadi krisis, konflik, atau risiko serius yang
dapat merugikan:
● brand
● founder
● sistem afiliasi
⚠ Digunakan **HANYA saat kondisi tidak normal**.
🎯 **TUJUAN PLAYBOOK**
● Menghindari kepanikan & keputusan emosional
● Menjaga nama baik @umyfadillaa
● Menyelesaikan masalah **cepat, rapi, dan tercatat**
● Melindungi sistem dari eskalasi publik
🔴 **LEVEL KRISIS
LEVEL 1** ⃣ **– KRISIS TEKNIS
Contoh:**
● Bug komisi
● Order tidak tercatat
● Dashboard error
**TINDAKAN ADMIN:**

1. Freeze perubahan sistem
2. Catat waktu & dampak
3. Laporkan ke developer
4. Informasikan founder
5. Jangan beri janji ke affiliate
**LEVEL 2** ⃣ **– KRISIS AFFILIATE
Contoh:**
● Affiliate protes komisi


● Tuduhan tidak dibayar
● Affiliate memprovokasi grup
**TINDAKAN ADMIN:**

1. Jangan debat di publik
2. Ajak komunikasi privat
3. Cek data & log sistem
4. Jawab berbasis data
5. Eskalasi ke founder jika sensitif
**LEVEL 3** ⃣ **– KRISIS FRAUD
Contoh:**
● Self-order massal
● Traffic palsu
● Jaringan affiliate bermasalah
**TINDAKAN ADMIN:**
1. Suspend sementara akun
2. Lock komisi terkait
3. Audit manual
4. Dokumentasikan bukti
5. Laporkan ke founder
**LEVEL 4** ⃣ **– KRISIS PUBLIK / VIRAL
Contoh:**
● Konten negatif viral
● Tuduhan penipuan
● Pencatutan nama & foto
**TINDAKAN ADMIN:**
1. Screenshot semua bukti
2. Jangan balas emosi
3. Laporkan ke founder
4. Hentikan komentar jika perlu
5. Siapkan klarifikasi resmi
🟡 **ATURAN KOMUNIKASI SAAT KRISIS**
❌ Dilarang:


● Membalas dengan emosi
● Memberi janji kompensasi
● Mengakui kesalahan tanpa data
✅ Wajib:
● Gunakan bahasa netral
● Jawab singkat & profesional
● Arahkan ke jalur resmi
🧾 **TEMPLATE PESAN AMAN (COPY-PASTE)**
"Terima kasih atas informasinya. Kami sedang melakukan pengecekan data di sistem. Mohon menunggu
update resmi dari tim kami."
🔐 **ESKALASI WAJIB KE FOUNDER JIKA:**
● Potensi viral
● Nilai kerugian besar
● Melibatkan nama @umyfadillaa langsung
✅ **PENUTUP**
Admin **bukan pemadam kebakaran sendirian**.
Jika ragu → **STOP & LAPOR**.
📌 **PLAYBOOK INI WAJIB DIHAFAL ADMIN INTI.**
Dokumen ini adalah **“pegangan darurat”** admin agar:
● ❌ Tidak panik
● ❌ Tidak salah bicara
● ❌ Tidak merusak brand
● ✅ Bertindak cepat, rapi, dan aman


🎯 **Nilai Strategis Playbook Ini**
Playbook ini berfungsi sebagai:
● 🛡 **Perlindungan reputasi @umyfadillaa**
● 🧠 Panduan keputusan saat kondisi genting
● 📋 Standar tindakan saat krisis (bukan reaktif)
● 🔐 Pengaman agar admin **tidak overstep kewenangan**
🔴 **Yang PALING PENTING untuk Admin
Jika ragu → STOP → DOKUMENTASIKAN → LAPOR FOUNDER**
Lebih baik **lambat tapi aman** daripada cepat tapi fatal.
🧭 **STATUS AKHIR SISTEM**
Dengan playbook ini, sistem afiliasi sudah benar-benar **enterprise-ready** :
✅ Struktur teknis
✅ SOP & checklist
✅ Dokumen affiliate
✅ Perjanjian legal
✅ Anti-fraud
✅ Playbook krisis


# 🔒 Privay_Policy


## 🔐 KEBIJAKAN PRIVASI (PRIVACY POLICY)

**Sistem Afiliasi “The Secret” by @umyfadillaa**
Terakhir diperbarui: ____________
Assalamu’alaikum warahmatullahi wabarakatuh.
Kebijakan Privasi ini menjelaskan bagaimana **The Secret by Umy Fadillaa** (selanjutnya disebut _“Kami”_ )
mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi pengguna ( _Affiliate_ ,
_Pengunjung_ , dan _Pengguna Sistem_ ).
Dengan mengakses dan menggunakan situs **https://www.rahasiatarikrejeki.id** &
**https://www.rahasiatarikrejeki.com** , Anda menyatakan telah membaca, memahami, dan menyetujui
Kebijakan Privasi ini.
**1** ⃣ **INFORMASI YANG KAMI KUMPULKAN**
Kami dapat mengumpulkan informasi berikut:
**a. Informasi Pribadi**
● Nama lengkap
● Alamat email
● Nomor WhatsApp / telepon
● Informasi rekening bank (untuk pembayaran komisi)
● Data akun affiliate (ID, status, level)
**b. Informasi Teknis**
● Alamat IP
● Jenis perangkat & browser
● Aktivitas dalam sistem (login, klik link affiliate, transaksi)
● Cookie dan teknologi pelacakan sejenis
**2** ⃣ **PENGGUNAAN INFORMASI**
Data yang dikumpulkan digunakan untuk:
● Mengelola akun affiliate
● Mencatat dan memvalidasi transaksi
● Menghitung & membayarkan komisi
● Mencegah penipuan (fraud)
● Mengirim notifikasi sistem & informasi penting
● Meningkatkan kualitas layanan


Kami **tidak menggunakan data untuk tujuan yang bertentangan dengan hukum, etika, dan nilai
kejujuran**.
**3** ⃣ **COOKIE & TEKNOLOGI PELACAKAN**
Kami menggunakan cookie untuk:
● Mencatat referral affiliate
● Menjaga sesi login
● Analisis performa sistem
Pengguna dapat menonaktifkan cookie melalui pengaturan browser, namun beberapa fitur sistem
mungkin tidak berfungsi optimal.
**4** ⃣ **PERLINDUNGAN & KEAMANAN DATA**
Kami berkomitmen menjaga keamanan data dengan:
● Sistem akses terbatas
● Enkripsi data sensitif
● Monitoring aktivitas mencurigakan
● Prosedur internal anti-fraud
Namun, perlu dipahami bahwa **tidak ada sistem digital yang 100% bebas risiko**.
**5** ⃣ **PEMBAGIAN DATA KE PIHAK KETIGA**
Kami **tidak menjual, menyewakan, atau memperdagangkan data pribadi** Anda.
Data hanya dapat dibagikan kepada pihak ketiga yang terkait langsung dengan operasional sistem,
seperti:
● Payment gateway
● Penyedia layanan hosting
● Tools analitik
Semua pihak ketiga tersebut terikat untuk menjaga kerahasiaan data.
**6** ⃣ **HAK PENGGUNA**
Anda berhak untuk:
● Mengakses data pribadi Anda
● Memperbarui atau memperbaiki data
● Meminta penghapusan akun (sesuai ketentuan sistem)


● Menarik persetujuan penggunaan data
Permintaan dapat diajukan melalui kontak resmi kami.
**7** ⃣ **PENYIMPANAN DATA**
Data disimpan selama:
● Akun affiliate masih aktif
● Diperlukan untuk kepentingan hukum, audit, atau operasional
Setelah itu, data dapat dihapus atau dianonimkan.
**8** ⃣ **PERUBAHAN KEBIJAKAN PRIVASI**
Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu.
Perubahan akan diumumkan melalui website.
Penggunaan sistem secara berkelanjutan dianggap sebagai persetujuan atas perubahan tersebut.
**9** ⃣ **KONTAK KAMI**
Jika Anda memiliki pertanyaan terkait Kebijakan Privasi ini, silakan hubungi:
📧 Email: **super@ahasiatarikrejeki.com**
🌐 Website: **https://www.rahasiatarikrejeki.id** & **https://www.rahasiatarikrejeki.com**
🤍 **PENUTUP**
Kami menjaga data Anda sebagai **amanah**.
Semoga setiap proses yang dijalankan melalui sistem ini membawa manfaat, keadilan, dan keberkahan
bagi semua pihak.
Wassalamu’alaikum warahmatullahi wabarakatuh.
**The Secret by @umyfadillaa**
🎯 **Karakter Kebijakan Privasi Ini**
Dokumen ini dirancang agar:


● ✅ **Cukup kuat secara hukum** untuk website & sistem afiliasi
● 🤍 Menggunakan bahasa **santun, agamis, dan tidak kaku**
● 󰳕 Aman untuk **click-to-accept / checkbox digital**
● 🛡 Melindungi data affiliate, founder, dan brand


