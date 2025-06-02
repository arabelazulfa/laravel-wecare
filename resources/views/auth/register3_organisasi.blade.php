@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
            width: 200px;
            font-weight: 600;
            color: #555;
        }

        .info-separator {
            width: 10px;
            text-align: center;
        }

        .info-value {
            flex: 1;
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

        img.logo-preview {
            margin-top: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 140px;
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
                <div class="info-row"><div class="info-label">Nama Kontak</div><div class="info-separator">:</div><div class="info-value">{{ $step1['name'] }}</div></div>
                <div class="info-row"><div class="info-label">Email</div><div class="info-separator">:</div><div class="info-value">{{ $step1['email'] }}</div></div>
                <div class="info-row"><div class="info-label">No. Telepon</div><div class="info-separator">:</div><div class="info-value">{{ $step1['phone'] }}</div></div>
            </div>

            <div>
                <div class="section-title">Detail Organisasi</div>
                <div class="info-row"><div class="info-label">Nama Organisasi</div><div class="info-separator">:</div><div class="info-value">{{ $step2['nama_organisasi'] }}</div></div>
                <div class="info-row"><div class="info-label">Tipe Organisasi</div><div class="info-separator">:</div><div class="info-value">{{ $step2['tipe_organisasi'] }}</div></div>
                <div class="info-row"><div class="info-label">Tanggal Berdiri</div><div class="info-separator">:</div><div class="info-value">{{ $step2['tanggal_berdiri'] }}</div></div>
                <div class="info-row"><div class="info-label">Lokasi</div><div class="info-separator">:</div><div class="info-value">{{ $step2['lokasi'] }}</div></div>
                <div class="info-row"><div class="info-label">Deskripsi Singkat</div><div class="info-separator">:</div><div class="info-value">{{ $step2['deskripsi_singkat'] ?? '-' }}</div></div>
                <div class="info-row"><div class="info-label">Fokus Utama</div><div class="info-separator">:</div><div class="info-value">{{ $step2['fokus_utama'] ?? '-' }}</div></div>
                <div class="info-row"><div class="info-label">Alamat</div><div class="info-separator">:</div><div class="info-value">{{ $step2['alamat'] }}</div></div>
                <div class="info-row"><div class="info-label">Provinsi</div><div class="info-separator">:</div><div class="info-value">{{ $step2['provinsi'] }}</div></div>
                <div class="info-row"><div class="info-label">Kabupaten/Kota</div><div class="info-separator">:</div><div class="info-value">{{ $step2['kabupaten_kota'] }}</div></div>
                <div class="info-row"><div class="info-label">Kode Pos</div><div class="info-separator">:</div><div class="info-value">{{ $step2['kodepos'] }}</div></div>
                <div class="info-row"><div class="info-label">No. Telepon Organisasi</div><div class="info-separator">:</div><div class="info-value">{{ $step2['no_telp'] }}</div></div>
                <div class="info-row"><div class="info-label">Website</div><div class="info-separator">:</div><div class="info-value">{{ $step2['website'] ?? '-' }}</div></div>

                @if(isset($step2['logo_path']))
                    <div class="info-row">
                        <div class="info-label">Logo</div>
                        <div class="info-separator">:</div>
                        <div class="info-value">
                            <img src="{{ asset('storage/' . $step2['logo_path']) }}" alt="Logo Organisasi" class="logo-preview" />
                        </div>
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
