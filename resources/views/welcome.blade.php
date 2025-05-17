<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <style>
        body {
            background-color: #f0f0f0;
        }
        .header {
            background-color: #ff6b6b;
            color: white;
            padding: 20px;
        }
        .main-content {
             background: linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)),
                url('/images/volunteer.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            margin: 20px;
            padding: 60px 20px;
            color: black;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .main-content h2 {
            font-weight: bold;
            font-size: 40px;
        }
        .stats {
            background-color: #ffcccb;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .stat {
            text-align: center;
            margin: 10px;
        }
        .stat i {
            font-size: 30px;
            margin-bottom: 10px;
            color: #ff6b6b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>WeCare</h1>
        <div class="float-end">
            <a href="{{ url('/login') }}" class="btn btn-light">Masuk</a>
            <a href="{{ url('/register') }}" class="btn btn-light">Daftar</a>
        </div>
    </div>

    <!-- Main content with background -->
    <div class="main-content">
        <h2>Welcome to WeCare</h2>
        <p>Ada harapan pada setiap gerakan.</p>
        <p>Mari bergabung bersama kami untuk mewujudkan harapan tersebut.</p>
       

        <a href="{{ url('/activities') }}" class="btn btn-danger mt-4">Cari Kegiatan</a>
    </div>

    <!-- Stats with icons -->
    <div class="stats">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
