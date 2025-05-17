<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - WeCare</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f0f0f0;
        }
        .header {
            background-color: #ff6b6b;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin: 40px auto;
            max-width: 600px;
        }
        .form-title {
            font-weight: bold;
            font-size: 30px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-section {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px;
        }
        .form-option {
            flex: 1;
            text-align: center;
            padding: 20px;
            border: 1px solid #ff6b6b;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.2s;
            color: inherit;
            text-decoration: none;
        }
        .form-option:hover {
            background-color: #ffcccb;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>WeCare</h1>
    </div>
    
    <div class="form-container">
        <h2 class="form-title">Daftar Sebagai:</h2>
        <div class="form-section">
            <a href="{{ url('/register/volunteer') }}" class="form-option">
                <i class="fas fa-user fa-3x mb-2"></i>
                <p>Volunteer</p>
            </a>
            <a href="{{ url('/register/organisasi') }}" class="form-option">
                <i class="fas fa-users fa-3x mb-2"></i>
                <p>Organisasi</p>
            </a>
        </div>
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-danger">Kembali</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
