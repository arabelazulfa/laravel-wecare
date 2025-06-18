@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Reset Password Baru</h2>

    <form method="POST" action="{{ route('password.reset.submit') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('reset_email') }}">

        <div class="mb-4">
            <label for="password" class="block">Password Baru</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Password</button>
    </form>
</div>
@endsection
