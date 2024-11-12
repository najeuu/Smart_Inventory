# PBL IF-15 Smart Inventory System for Efficiency Stock Management Using RFID

Identitas Kelompok: 

<br>
3312301028 - Cindy Fitri Utami
<br>
3312301061 - Sindy Maharani
<br>
3312301066 - Nazhwa Rahma Putri
<br>
3312311104 - Yunita Caroline Sianturi 
<br>
3312311133 - Grey Ari Daniel Simatupang

## About the App

Proyek Smart Inventory Using RFID ini merupakan sebuah proyek kolaborasi oleh tim PBL IF-15. Sistem ini dirancang berbasis web menggunakan RFID untuk meingkatkan efisiensi dalam inventaris lab kampus. 
<br>
Fitur-fitur utama dalam proyek ini yaitu :
<br>
- Identifikasi dan pelacakan item inventaris secara otomatis menggunakan tag RFID. 
- Pemantauan secara real-time
- Pelaporan stok yang efisien
- Integrasi dengan sistem manajemen berbasis web

## Installation

1. **Clone this repository**:
 ```bash
git clone https://github.com/najeuu/smart-inventory-system.git
```

2. **Masuk ke direktori proyek**:
```bash
cd Smart_Inventory
```

3. **Install dependencies (pastikan Composer sudah terpasang)**:
```bash
composer install
```

4. **Update Composer Autoload and Dependencies**
```bash
composer dump-autoload
composer update
```
5. **Launch The App**
```bash
php artisan serve
```

## Handling Errors

If you encounter errors, follow these steps:

1. **Recovery Procedure**:

   ```bash
   php artisan serve
   ```

2. **If you encounter an Error Code 500**:

   - Rename `.env-example` to `.env`.
   - Set `APP_DEBUG=true` in the `.env` file.

3. **Generate New Application Key**:

   ```bash
   php artisan key:generate
   ```

4. **Restart the Server**:

   ```bash
   php artisan serve
   