## Tentang Sistem Informasi Geografi UMKM Kota Bogor

Website ini adalah Sistem Informasi Geografi (SIG) yang dirancang untuk memetakan Usaha Mikro, Kecil, dan Menengah (UMKM) di Kota Bogor. Website ini menyediakan visualisasi choropleth dengan perhitungan statistika deskriptif untuk menunjukkan perbedaan jumlah UMKM di enam kecamatan di Kota Bogor.

## Fitur

-   **Choropleth Map:** Visualisasi data UMKM dalam bentuk peta yang menunjukkan distribusi jumlah UMKM di enam kecamatan di Kota Bogor.
-   **Statistika Deskriptif:** Menyediakan perhitungan statistika deskriptif untuk menganalisis data UMKM.
-   **Register & Login:** Fitur untuk pengguna baru mendaftarkan diri dan pengguna terdaftar untuk masuk ke dalam sistem.
-   **CRUD Data UMKM:**
    -   **Admin:** Memiliki kapabilitas penuh untuk Create, Read, Update, dan Delete data UMKM.
    -   **Pengguna Biasa:** Dapat mendaftarkan UMKM mereka dan akan dianggap sebagai pelaku UMKM.

## Teknologi

-   **Framework:** Laravel
-   **Database:** MySQL

## Manfaat

### Pelaku UMKM

-   **Visibilitas:** Memperluas jangkauan UMKM melalui pemetaan online yang dapat diakses oleh masyarakat luas.
-   **Analisis Data:** Memungkinkan pelaku UMKM untuk melihat data statistik yang dapat membantu dalam pengambilan keputusan bisnis.

### Konsumen UMKM

-   **Akses Informasi:** Memudahkan konsumen dalam menemukan UMKM terdekat di sekitar mereka.
-   **Pemahaman Pasar:** Membantu konsumen memahami distribusi UMKM di berbagai kecamatan di Kota Bogor.

### Dinas Koperasi Usaha Kecil Menengah Perdagangan dan Perindustrian Kota Bogor

-   **Monitoring:** Memudahkan dalam memantau dan mengelola perkembangan UMKM di Kota Bogor.
-   **Pengambilan Keputusan:** Menyediakan data yang relevan untuk pembuatan kebijakan dan pengambilan keputusan yang lebih baik.

## Instalasi

1. Clone repository ini:
    ```bash
    git clone https://github.com/nielraja123/sigumkmbogor.git
    ```
2. Masuk ke direktori proyek:
    ```bash
    cd repository
    ```
3. Install dependencies:
    ```bash
    composer install
    npm install
    npm run dev
    ```
4. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database:
    ```bash
    cp .env.example .env
    ```
5. Generate application key:
    ```bash
    php artisan key:generate
    ```
6. Migrasi database:
    ```bash
    php artisan migrate
    ```

## Penggunaan

1. Jalankan server lokal:
    ```bash
    php artisan serve
    ```
2. Akses website melalui browser pada alamat:
    ```
    http://localhost:8000
    ```

## Catatan

Website ini dibuat oleh **Andre Nathaniel Adipraja** dengan NPM **140810200042** sebagai tugas akhir program studi Teknik Informatika, Universitas Padjadjaran.

---

Untuk kontribusi atau pertanyaan lebih lanjut, silakan hubungi saya di [nielraja123@gmail.com](mailto:nielraja123@gmail.com).

Terima kasih telah menggunakan aplikasi ini! 😊
