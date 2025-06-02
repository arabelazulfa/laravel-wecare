<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Preview Pendaftaran Organisasi</title>
    <style>
        body {
            margin: 0;
            background-color: #fddde6;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .header-bar {
            background-color: #f48ca5;
            color: white;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            padding: 20px 0;
            user-select: none;
        }

        .preview-wrapper {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .preview-card {
            background-color: white;
            width: 100%;
            max-width: 1000px;
            padding: 40px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        h3 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 36px; /* diperbesar */
            font-weight: 700;
            color: #d6336c;
            letter-spacing: 1.2px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-top: 35px;
            margin-bottom: 15px;
            color: #444;
            border-bottom: 2px solid #f48ca5;
            padding-bottom: 5px;
            letter-spacing: 0.5px;
        }

        p {
            margin: 8px 0;
            font-size: 16px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 180px;
            display: inline-block;
        }

        .form-button {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }

        .btn-primary-custom {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            padding: 12px 36px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.4);
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
        }

        img {
            margin-top: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="header-bar">WeCare</div>

    <div class="preview-wrapper">
        <div class="preview-card">
            <h3>Preview Pendaftaran Organisasi</h3>

            <div>
                <div class="section-title">Informasi Kontak</div>
                <p><span class="info-label">Nama Kontak:</span> {{ $step1['name'] }}</p>
                <p><span class="info-label">Email:</span> {{ $step1['email'] }}</p>
                <p><span class="info-label">No. Telepon:</span> {{ $step1['phone'] }}</p>
            </div>

            <div>
                <div class="section-title">Detail Organisasi</div>
                <p><span class="info-label">Nama Organisasi:</span> {{ $step2['nama_organisasi'] }}</p>
                <p><span class="info-label">Tipe Organisasi:</span> {{ $step2['tipe_organisasi'] }}</p>
                <p><span class="info-label">Tanggal Berdiri:</span> {{ $step2['tanggal_berdiri'] }}</p>
                <p><span class="info-label">Lokasi:</span> {{ $step2['lokasi'] }}</p>
                <p><span class="info-label">Deskripsi Singkat:</span> {{ $step2['deskripsi_singkat'] ?? '-' }}</p>
                <p><span class="info-label">Fokus Utama:</span> {{ $step2['fokus_utama'] ?? '-' }}</p>
                <p><span class="info-label">Alamat:</span> {{ $step2['alamat'] }}</p>
                <p><span class="info-label">Provinsi:</span> {{ $step2['provinsi'] }}</p>
                <p><span class="info-label">Kabupaten/Kota:</span> {{ $step2['kabupaten_kota'] }}</p>
                <p><span class="info-label">Kode Pos:</span> {{ $step2['kodepos'] }}</p>
                <p><span class="info-label">No. Telepon Organisasi:</span> {{ $step2['no_telp'] }}</p>
                <p><span class="info-label">Website:</span> {{ $step2['website'] ?? '-' }}</p>

                @if(isset($step2['logo_path']))
                    <p><span class="info-label">Logo:</span></p>
                    <img src="{{ asset('storage/' . $step2['logo_path']) }}" alt="Logo Organisasi" width="140" />
                @endif
            </div>

            <form method="POST" action="{{ route('register.organisasi.konfirmasi') }}" class="form-button">
                @csrf
                <button type="submit" class="btn-primary-custom">Buat Akun</button>
            </form>
        </div>
    </div>
</body>
</html>
