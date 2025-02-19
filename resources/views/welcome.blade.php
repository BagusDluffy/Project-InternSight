<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Sight</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* General Reset */
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #fff;
            background-color: black;
            background-size: 100vh;
            line-height: 1.6;
            font-family: 'Clash Display', Arial, sans-serif;
        }



        /* Hero Section */
        .hero {
            height: 100vh;
            background-image: url('{{ asset("assets/background.png") }}');
            background-size: 98% 98%;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Warna overlay hitam dengan transparansi */
            z-index: 1;
            /* Overlay berada di atas background */
        }

        .hero-content {
            position: absolute;
            bottom: 20px;
            /* Sesuaikan posisi ke kiri bawah */
            left: 20px;
            z-index: 2;
            /* Pastikan konten berada di atas overlay */
            text-align: left;
        }


        /* Header */
        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0);
            /* Transparansi background header */
            padding: 1rem 2rem;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        header .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        header .logo img {
            height: 40px;
        }

        header .left-nav,
        header .right-nav {
            display: flex;
            gap: 1rem;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
        }

        header .login-btn {
            background-color: #444;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            background-color: transparent;
            /* Membuat background transparan */
            color: #fff;
            /* Teks tetap terlihat (pilih warna yang kontras dengan background) */
            padding: 0.5rem 1rem;
            border: 2px solid #fff;
            /* Tambahkan border agar tombol terlihat */
            cursor: pointer;
        }

        header .login-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Efek transparan saat hover */
            color: #fff;
            /* Warna teks tetap */


        }

        /* Hero Content */
        .hero-content {
            position: absolute;
            bottom: 2rem;
            /* Jarak dari bawah */
            left: 2rem;
            /* Jarak dari kiri */
            text-align: left;
            /* Teks rata kiri */
            color: #fff;
        }

        .hero-content h1 {
            font-size: 7rem;
            /* Ukuran lebih besar untuk h1 */
            font-weight: bold;
            text-transform: uppercase;
            /* Huruf besar semua */
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.1rem;
            /* Ukuran teks */
            max-width: 900px;
            /* Lebar maksimum untuk mengontrol panjang teks */
            margin: 0 auto;
            /* Untuk memusatkan */
            text-align: left;
            /* Menyelaraskan teks ke kiri */
            line-height: 1.5;
            /* Jarak antar baris */
        }




        /* About Section */
        .about {
            display: flex;
            flex-direction: column;
            /* Mengatur elemen di dalam .about menjadi vertikal */
            align-items: flex-end;
            /* Menyelaraskan elemen ke kanan secara horizontal */
            padding: 3rem 2rem;
            margin-right: 1.5rem;
            background-size: 100vh;
        }

        .about p {
            font-size: 1.5rem;
            /* Ukuran font besar */
            line-height: 1.2;
            /* Jarak antar baris agar tidak terlalu rapat */
            max-width: 600px;
            /* Menentukan lebar maksimal untuk teks */
            margin: 0;
            /* Menghapus margin default */
            margin-bottom: 2rem;
            /* Memberikan jarak antara teks dan kartu */
        }

        .cards {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .card {
            width: 300px;
            height: 200px;
            overflow: hidden;
            /* Agar gambar yang lebih besar terpotong */
            border-radius: 10px;
            /* Membuat sudut membulat */
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Gambar menyesuaikan dengan card tanpa distorsi */
            border-radius: 10px;
            /* Sesuaikan dengan card */
        }





        /* Call-to-Action Section */
        .cta {
            text-align: center;
            padding: 3rem 2rem;
        }

        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .cta .cta-image {
            width: 80%;
            height: 200px;
            margin: 0 auto;
            border-radius: 10px;
        }

        .cta .contact-btn {
            background-color: transparent;
            /* Membuat background transparan */
            color: #fff;
            /* Teks tetap terlihat (pilih warna yang kontras dengan background) */
            padding: 0.5rem 1rem;
            border: 2px solid #fff;
            /* Tambahkan border agar tombol terlihat */
            cursor: pointer;
            margin-top: 1rem;
            border-radius: 5px;
            /* Opsional: membuat sudut tombol membulat */
            transition: all 0.3s ease;
            /* Tambahkan efek transisi */
        }

        /* Tambahkan efek hover untuk tombol */
        .cta .contact-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Efek transparan saat hover */
            color: #fff;
            /* Warna teks tetap */
        }

        /* footer */

        .footer {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-img {
            width: 35px;
            height: auto;
            /* Membuat ukuran gambar responsif */
        }

        .social-media {
            text-align: right;
        }

        .social-media span {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #fff;
        }

        .icons a {
            margin-left: 10px;
            color: #fff;
            font-size: 24px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .icons a:hover {
            color: #1da1f2;
            /* Mengubah warna ikon saat hover */
        }
    </style>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Internship Sight</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

<body>
    <div class="hero">
        <header>
            <div class="container">
                <nav class="left-nav">
                    <a href="#">Home</a>
                    <a href="#">About</a>
                </nav>
                <div class="logo">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img">
                </div>
                <nav class="right-nav">
                    @if (Auth::check())
                    <a href="{{ route('home') }}" class="login-btn">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                    @endif
                </nav>
            </div>
        </header>

        <div class="hero-content">
            <h1><span>mempermudah</span><br><span>monitoring</span></h1>
            <p>Internship Sight menghadirkan solusi online yang dirancang untuk membantu</p>
            <p>guru memantau perkembangan siswa magang secara real-time.</p>
        </div>
    </div>
    <!-- section 2 -->

    <section class="about">
        <p>
            Dengan fokus pada kemudahan, transparansi, dan <br>
            aksesibilitas, Internship Sight dirancang untuk <br>
            menjadi solusi andalan bagi guru, siswa, dan perusahaan.
        </p>
        <div class="cards">
            <div class="card">
                <img src="{{ asset('assets/foto1.jpg') }}" alt="Card 1" class="card-img">
            </div>
            <div class="card">
                <img src="{{ asset('assets/foto2.jpg') }}" alt="Card 2" class="card-img">
            </div>
        </div>
    </section>



    <section class="cta">
        <h2>Kenapa Tidak Bergabung?</h2>
        <p>Dengan kami, mempermudah guru untuk menjadi penghubung anak murid dengan dunia pekerjaan.</p>
        <div class="cta-image">
            <img src="{{ asset('assets/img3.png') }}" alt="Card 2" class="card-img">
        </div>
        <button class="contact-btn">Contact Us</button>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <!-- Logo Section -->
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img">
            </div>
            <!-- Social Media Section -->
            <div class="social-media">
                <span>SOCIAL MEDIA</span>
                <div class="icons">
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>