# Juliandebitair — Sistem Manajemen Air Berbasis IoT

Aplikasi web manajemen tagihan air berbasis Laravel dengan integrasi IoT real-time menggunakan MQTT (HiveMQ Cloud). Admin dapat memantau pemakaian air, mengelola tagihan, dan mengontrol katup air dari dashboard. Pengguna dapat melihat riwayat pemakaian dan melakukan pembayaran via Midtrans.

---

## Fitur

- **Dashboard Admin** — ringkasan tagihan, pengguna, dan status sistem
- **Kelola Pengguna** — CRUD data pelanggan air
- **Kelola Tagihan** — buat, edit, hapus tagihan per bulan per pengguna
- **Water Usage Real-time** — monitoring meteran air langsung dari perangkat IoT via MQTT, update otomatis setiap 3 detik
- **Kontrol Katup** — admin dapat membuka/menutup katup air dari dashboard, perintah dikirim ke IoT via MQTT
- **Pengaturan Sistem** — kelola informasi dan tarif air
- **Dashboard Pengguna** — pengguna melihat tagihan dan status pembayaran
- **Pembayaran Online** — integrasi Midtrans untuk pembayaran tagihan

---

## Teknologi

| Layer | Stack |
|---|---|
| Backend | Laravel 11, PHP |
| Frontend | Blade, Tailwind CSS, AdminLTE, Vite |
| Database | MySQL (XAMPP) |
| IoT Broker | HiveMQ Cloud (MQTT over TLS port 8883) |
| MQTT Client | `php-mqtt/client` v2.3.2 |
| Payment | Midtrans |

---

## Persyaratan

- PHP >= 8.2
- Composer
- Node.js & NPM
- XAMPP (MySQL)
- Akun HiveMQ Cloud

---

## Instalasi

```bash
# 1. Clone repository
git clone https://github.com/juliandwi1307-hub/juliandebitair.git
cd juliandebitair

# 2. Install dependencies
composer install
npm install

# 3. Salin file environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi .env
# Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Isi MQTT_HOST, MQTT_USERNAME, MQTT_PASSWORD
# Isi MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY

# 5. Jalankan migrasi
php artisan migrate

# 6. Import data awal (opsional)
# Import juliandebitair.sql via phpMyAdmin
```

---

## Konfigurasi `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=juliandebitair
DB_USERNAME=root
DB_PASSWORD=

MQTT_HOST=<hivemq-host>.hivemq.cloud
MQTT_PORT=8883
MQTT_USERNAME=<mqtt-username>
MQTT_PASSWORD=<mqtt-password>
MQTT_CLIENT_ID=laravel-juliandebitair

MIDTRANS_SERVER_KEY=<server-key>
MIDTRANS_CLIENT_KEY=<client-key>
MIDTRANS_IS_PRODUCTION=false
```

---

## Menjalankan Aplikasi

Butuh **3 terminal** yang berjalan bersamaan:

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite assets (CSS/JS)
npm run dev

# Terminal 3 — MQTT listener (IoT real-time)
php artisan mqtt:listen
```

Akses aplikasi di `http://127.0.0.1:8000`

---

## MQTT Flow

### IoT → Laravel
Topic: `/user/waterflow`

```json
{"id": 1, "now": 36, "flow_rate": 1.91, "total_liters": 36.740, "valve": "OPEN"}
```

| Field | Keterangan |
|---|---|
| `id` | ID pengguna di database |
| `now` | Nilai meteran saat ini (m³) |
| `flow_rate` | Laju aliran air (L/menit) |
| `total_liters` | Total liter sejak reset |
| `valve` | Status katup: `OPEN` / `CLOSED` |

Command `php artisan mqtt:listen` akan:
1. Update `pengguna.meter_akhir` dengan nilai `now`
2. Update `pengguna.water_status` dari field `valve`
3. Simpan log ke tabel `sensor_logs`
4. Sinkronkan tagihan bulan ini di tabel `tagihans`

### Laravel → IoT
Topic: `user/watercontrol`

```json
{"id": 1, "status": "True"}
```

Dikirim saat admin toggle status katup dari dashboard.

---

## Struktur Database

| Tabel | Keterangan |
|---|---|
| `pengguna` | Data pelanggan, menyimpan `meter_awal`, `meter_akhir`, `water_status` |
| `tagihans` | Tagihan per bulan per pengguna |
| `tarifs` | Harga tarif air per m³ |
| `pengaturan` | Informasi/pengumuman dari admin |
| `sensor_logs` | Log historis pembacaan meteran dari IoT |
| `admins` | Akun admin |

---

## URL Penting

| URL | Keterangan |
|---|---|
| `/dashboard-admin` | Dashboard admin |
| `/waterusage` | List pemakaian semua pengguna (admin) |
| `/waterusage/{id}` | Detail + real-time monitoring per pengguna |
| `/tagihan` | Kelola tagihan (admin) |
| `/pengaturan` | Pengaturan tarif & informasi |
| `/dashboard-pengguna` | Dashboard pengguna |
| `/pemakaian-air` | Riwayat pemakaian real-time (pengguna) |
| `/infobayar` | Riwayat & pembayaran tagihan (pengguna) |

---

## Lisensi

MIT
