# Sistem Absensi Rich

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://laravel.com/img/logotype.min.svg" alt="Laravel Logo" width="200">
  </a>
</p>

Sistem Absensi Rich adalah aplikasi absensi berbasis web yang memanfaatkan **Laravel** sebagai framework utama. Sistem ini dirancang untuk memudahkan proses absensi, baik melalui **QR Code** maupun **kartu RFID**. Selain itu, aplikasi juga menyediakan dashboard admin yang menampilkan statistik absensi dan data siswa secara interaktif.

---

## Demo & Tampilan

1. **Halaman Absensi (Scan QR / RFID)**  
   <img src="https://github.com/rizkyadiryanto14/absensi-rich/blob/main/rich/absensi.png" alt="Halaman Absensi" width="400"/>

2. **Dashboard Admin**  
   <img src="https://github.com/rizkyadiryanto14/absensi-rich/blob/main/rich/dashboard.png" alt="Dashboard Admin" width="400"/>

3. **Contoh Tampilan Lain**  
   <img src="https://github.com/rizkyadiryanto14/absensi-rich/blob/main/rich/gambar1.png" alt="Contoh Gambar 1" width="400"/>  
   <img src="https://github.com/rizkyadiryanto14/absensi-rich/blob/main/rich/gambar2.png" alt="Contoh Gambar 2" width="400"/>

4. **Manajemen Siswa**  
   <img src="https://github.com/rizkyadiryanto14/absensi-rich/blob/main/rich/siswa.png" alt="Halaman Siswa" width="400"/>

---

## Fitur Utama

- **Scan QR Code**  
  Memudahkan siswa untuk melakukan absensi dengan memindai QR Code langsung melalui kamera perangkat (menggunakan library [html5-qrcode](https://github.com/mebjas/html5-qrcode)).

- **Scan Kartu RFID**  
  Alternatif absensi dengan kartu RFID yang juga tercatat secara otomatis.

- **Dashboard Admin**  
  Menyediakan statistik jumlah siswa, rekap absensi harian, serta grafik absensi bulanan (menggunakan [Chart.js](https://www.chartjs.org/)).

- **Manajemen Siswa**  
  Tambah, edit, dan hapus data siswa, termasuk informasi orang tua, nomor HP, serta token QR.

- **Export Data**  
  Mendukung export data absensi ke format Excel (menggunakan [Maatwebsite Excel](https://github.com/Maatwebsite/Laravel-Excel)).

---

## Teknologi yang Digunakan

- **Laravel**  
  Memanfaatkan keunggulan Laravel seperti routing yang mudah, Eloquent ORM, migration, dan lainnya.

- **Tailwind CSS**  
  Untuk tampilan antarmuka yang modern dan responsif.

- **Yajra DataTables**  
  Menangani data server-side, pagination, search, dan sort secara efisien.

- **Maatwebsite Excel**  
  Mempermudah proses export data absensi ke file Excel.

- **html5-qrcode**  
  Menggunakan API kamera perangkat (getUserMedia) untuk memindai QR Code secara langsung.

---

## Cara Instalasi & Menjalankan

1. **Clone repository** ini:
   ```bash
   git clone https://github.com/rizkyadiryanto14/absensi-rich.git

2. **Masuk kedalam direktori project**
    ```bash
    cd absensi-rich

3. **Instal dependency menggunakan Composer**
   ```bash
   composer install

4. **Copy file .env dan sesuaikan konfigurasi database**
     ```bash
   cp .env.example .env
5. **Generate Key**
   ```bash
   php artisan key:generate

6. **Jalankan migration**
   ```bash
   php artisan migrate

7. **Jalankan Server**
   ```bash
   php artisan serve

