<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WeCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff5f5;
            overflow-x: hidden;
        }

        .navbar-brand {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .navbar-custom {
            background-color: #ff6b6b;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .btn {
            border-radius: 30px;
            padding: 8px 20px;
        }

        .carousel-item {
            height: 450px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .carousel-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background-color: rgba(255, 192, 203, 0.4);
            /* Pink pastel transparan */
            z-index: 0;
            pointer-events: none;
        }

        .carousel-caption {
            position: center;
            z-index: 3;
            bottom: 20%;
        }

        .carousel-caption h2 {
            font-size: 3rem;
            font-weight: 700;
        }

        .carousel-caption p {
            font-size: 18px;
        }

        .carousel-caption .btn {
            font-size: 18px;
            padding: 10px 25px;
            border-radius: 30px;
            color: #fff;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            padding: 50px 20px;
            background-color: #fff0f0;
        }

        .stat {
            width: 220px;
            text-align: center;
            background: #ffffff;
            padding: 30px 20px;
            border-radius: 20px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .stat i {
            font-size: 40px;
            color: #ff6b6b;
            margin-bottom: 15px;
        }

        .stat h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .stat p {
            font-size: 16px;
            color: #777;
        }

        footer {
            background-color: #ff6b6b;
            color: white;
            text-align: center;
            padding: 20px 10px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .carousel-caption h2 {
                font-size: 2rem;
            }

            .stat {
                width: 100%;
                max-width: 320px;
            }
        }

        .btn-danger {
            background-color: #ff4d4d !important;
            /* merah pastel cerah */
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #e60000 !important;
            transform: scale(1.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 1s ease-out both;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid px-4">
            <h1 class="navbar-brand text-white fw-bold">WeCare</h1>
            <div class="d-flex">
                <a href="{{ url('/login') }}" class="btn btn-light me-2">Masuk</a>
                <a href="{{ url('/register') }}" class="btn btn-outline-light">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Carousel Hero Section -->
    <div id="carouselHero" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('/images/volunteer.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-black fw-bold fade-in-up">Selamat Datang di WeCare</h2>
                    <p class="text-black fade-in-up" style="animation-delay: 0.3s;">Gabung dan buat perubahan bersama
                        kami</p>
                    <a href="{{ route('volunteer.events') }}" class="btn btn-danger mt-3 fade-in-up"
                        style="animation-delay: 0.6s;">Cari Kegiatan</a>
                </div>

            </div>
            <div class="carousel-item" style="background-image: url('/images/volunteer2.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-black fw-bold fade-in-up">Bersama Kita Bisa</h2>
                    <p class="text-black fade-in-up" style="animation-delay: 0.3s;">Jadilah bagian dari gerakan kebaikan</p>
                    <a href="{{ route('volunteer.events') }}" class="btn btn-danger mt-3 fade-in-up" style="animation-delay: 0.6s;">Gabung Sekarang</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('/images/volunteer3.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-black fw-bold fade-in-up">Aksi Nyata untuk Harapan</h2>
                    <p class="text-black fade-in-up" style="animation-delay: 0.3s;">Setiap tindakan kecil berarti besar</p>
                    <a href="{{ route('volunteer.events') }}" class="btn btn-danger mt-3 fade-in-up" style="animation-delay: 0.6s;">Mulai Sekarang</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHero" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselHero" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat">
            <i class="fas fa-hands-helping"></i>
            <h3>12,345</h3>
            <p>Volunteer</p>
        </div>
        <div class="stat">
            <i class="fas fa-building"></i>
            <h3>567</h3>
            <p>Organisasi</p>
        </div>
        <div class="stat">
            <i class="fas fa-calendar-check"></i>
            <h3>8,765</h3>
            <p>Kegiatan</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 WeCare. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>