@extends('layouts.app')

@section('content')
    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger max-w-md mx-auto mt-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

            <form method="POST" action="{{ route('register.organisasi.finalize') }}" class="form-button">
                @csrf
                <button type="submit" class="btn-primary-custom">Buat Akun</button>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            max-width: 960px;
            margin: 30px auto;
            padding: 0 16px;
        }

        .preview-card {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            font-size: 14px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: rgb(2, 2, 2);
            letter-spacing: 1px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin-top: 25px;
            margin-bottom: 12px;
            color: #444;
            border-bottom: 2px solid #f48ca5;
            padding-bottom: 4px;
        }

        .info-row {
            display: flex;
            margin: 6px 0;
            font-size: 14px;
            align-items: flex-start;
        }

        .info-label {
            width: 180px;
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
            margin-top: 30px;
        }

        .btn-primary-custom {
            background-color: #007bff;
            color: white;
            font-size: 14px;
            padding: 10px 28px;
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
            max-width: 120px;
            height: auto;
        }
    </style>
@endsection


