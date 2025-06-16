@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Reset Password via OTP</h2>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block font-semibold text-sm">Email</label>
            <input type="email" name="email" required class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim OTP</button>
    </form>
</div>
@endsection
