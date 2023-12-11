<p align="center"><img src="https://storage.agileteknik.com/media-library/8/R6ztgTu9hAmIEB8nQ2uplkyh3wsW5D-metaYWdpbGUtdGVrbmlrLWg1MHB4ICgxKS5wbmc=-.png" width="100%"></p>
<br>
<p align="center"><img src="https://storage.agileteknik.com/media-library/83/t6270zp2Ud6g0Rgb8tBITVSlcM66NK-metaTG9nbyAoMSkucG5n-.png" width="100%"></p>

## About this Project

Projek ini tentang backend sebuah aplikasi pencatatan transaksi yang dilakukan oleh user. Untuk mengetahui lebih detail, anda bisa mengunjungi landing page [Simple Wallet](https://simplewallet.agileteknik.com/)

Team Backend Simple Wallet

# Tutorial Github

## Forking dari Repository Utama

1. Buka Halaman [Repo](https://github.com/agilepdbl/2023backend-finance)

2. Tekan Icon Fork

## Mengcloning Repository Hasil Forking

1. Buka Halaman Github Anda

2. Pilih Repository Hasil Forking

3. Pada Komputer Anda Buka Console / Command Promt

4. Ketikan Perintah Berikut

```
git clone https://github.com/agilepdbl/2023backend-finance.git
```

4. Masuk Ke Dalam Folder Hasil Clone

```
cd 2023backend-finance
```

## Hubungkan dengan repository utama

1. Ketikan perintah berikut pada folder repo hasil forking anda

```
git remote add upstream https://github.com/agilepdbl/2023backend-finance.git
```

2. Ketikan perintah berikut untuk mengupdate data terbaru

```
git fetch upstream
```

3. Untuk mendownload data terbaru dari branch master gunakan perintah berikut

```
git pull upstream master
```


# Tutorial Penggunaan & Konfigurasi Laravel

1. Install Composer Terlebih Dahulu <br>
   [Download disini](https://getcomposer.org/download/)
2. Install Packagenya Terlebih Dahulu

```
composer install
```

3. Copy isi file .env.example

```
cp .env.example .env
```

4. Generate Key Baru

```
php artisan key:generate
```

5. Buatlah database kosong di phpmyadmin dengan nama **simple_wallet**
6. Ubah pengaturan database pada .env
```
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
```
7. Lakukan Migrasi Database

```
php artisan migrate
```

8. Jalankan aplikasi

```
php artisan serve
```
