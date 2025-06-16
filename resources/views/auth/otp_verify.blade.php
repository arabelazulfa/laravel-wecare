@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Verifikasi OTP</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            <ul class="text-sm list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <div class="mb-4">
            <label for="otp_code" class="block font-semibold text-sm">Kode OTP</label>
            <input type="text" name="otp_code" required class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Verifikasi</button>
    </form>
</div>
@endsection
