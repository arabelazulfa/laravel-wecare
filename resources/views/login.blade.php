@extends('layouts.app')

@if ($errors->any())
  <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
    <ul class="text-sm pl-5 list-disc">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@section('content')
<div class="flex justify-center items-start min-h-screen pt-8">
    <form method="POST" action="{{ url('/login') }}" autocomplete="off" class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6 relative" spellcheck="false">
        @csrf

        <div class="pt-18"></div> {{-- Spacer to avoid overlapping WeCare text --}}

        <h2 class="text-center text-black text-3xl mb-4 font-semibold">Masuk</h2>

        {{-- Email --}}
        <label class="block text-black text-sm font-semibold mb-1" for="email">
            Email Address
        </label>
        <input name="email" class="w-full rounded-md py-2 px-3 mb-4 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F19494]" id="email" placeholder="Enter your email" required type="email"/>

        {{-- Password --}}
        <label class="block text-black text-sm font-semibold mb-1" for="password">
            Password
        </label>
        <input name="password" class="w-full rounded-md py-2 px-3 mb-1 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F19494]" id="password" placeholder="Enter your password" required type="password"/>

        {{-- Lupa password --}}
        <div class="text-right text-xs text-black mb-4">
            <a href="{{ route('otp.email') }}" class="text-[#4A7CFD] font-semibold hover:underline">Lupa password?</a>
        </div>

        {{-- Tombol Masuk --}}
        <button class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg mb-3 hover:bg-[#3a66d9] transition-colors" type="submit">
            Masuk
        </button>

        {{-- Divider --}}
        <div class="text-center text-xs text-black mb-3">Atau masuk dengan</div>

        {{-- Login Google --}}
        <button class="w-full bg-white rounded-md py-2 flex justify-center items-center gap-2" type="button">
            <img alt="Google logo" class="w-5 h-5" src="https://developers.google.com/identity/images/g-logo.png" width="20" height="20"/>
            <span class="text-sm text-black">Google</span>
        </button>

        {{-- Punya akun --}}
        <p class="text-center text-xs text-black mt-4">
            Belum punya akun?
            <a class="text-[#4A7CFD] font-semibold hover:underline" href="/register">Daftar</a>
        </p>
    </form>
</div>
@endsection
