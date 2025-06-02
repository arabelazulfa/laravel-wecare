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
            font-size: 36px;
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

        .info-row {
            display: flex;
            margin: 8px 0;
            font-size: 16px;
            align-items: flex-start;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 200px;
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
            margin-top: 5px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 200px;
            height: auto;
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
                <div class="info-row"><span class="info-label">Nama Kontak:</span><span>{{ $step1['name'] }}</span></div>
                <div class="info-row"><span class="info-label">Email:</span><span>{{ $step1['email'] }}</span></div>
                <div class="info-row"><span class="info-label">No. Telepon:</span><span>{{ $step1['phone'] }}</span></div>
            </div>

            <div>
                <div class="section-title">Detail Organisasi</div>
                <div class="info-row"><span class="info-label">Nama Organisasi:</span><span>{{ $step2['nama_organisasi'] }}</span></div>
                <div class="info-row"><span class="info-label">Tipe Organisasi:</span><span>{{ $step2['tipe_organisasi'] }}</span></div>
                <div class="info-row"><span class="info-label">Tanggal Berdiri:</span><span>{{ $step2['tanggal_berdiri'] }}</span></div>
                <div class="info-row"><span class="info-label">Lokasi:</span><span>{{ $step2['lokasi'] }}</span></div>
                <div class="info-row"><span class="info-label">Deskripsi Singkat:</span><span>{{ $step2['deskripsi_singkat'] ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Fokus Utama:</span><span>{{ $step2['fokus_utama'] ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Alamat:</span><span>{{ $step2['alamat'] }}</span></div>
                <div class="info-row"><span class="info-label">Provinsi:</span><span>{{ $step2['provinsi'] }}</span></div>
                <div class="info-row"><span class="info-label">Kabupaten/Kota:</span><span>{{ $step2['kabupaten_kota'] }}</span></div>
                <div class="info-row"><span class="info-label">Kode Pos:</span><span>{{ $step2['kodepos'] }}</span></div>
                <div class="info-row"><span class="info-label">No. Telepon Organisasi:</span><span>{{ $step2['no_telp'] }}</span></div>
                <div class="info-row"><span class="info-label">Website:</span><span>{{ $step2['website'] ?? '-' }}</span></div>

                @if(isset($step2['logo_path']))
                    <div class="info-row">
                        <span class="info-label">Logo:</span>
                        <span><img src="{{ asset('storage/' . $step2['logo_path']) }}" alt="Logo Organisasi"></span>
                    </div>
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
