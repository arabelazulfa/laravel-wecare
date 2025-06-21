<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Verifikasi OTP - WeCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Poppins", sans-serif;
    }

    input.otp-box {
      width: 3rem;
      height: 3rem;
      text-align: center;
      font-size: 1.25rem;
      border: 1px solid #ccc;
      border-radius: 0.375rem;
    }
  </style>
</head>

<body class="bg-[#FCE9E9] min-h-screen flex flex-col items-center pt-8 px-4">
  <div class="bg-[#F19494] rounded-lg w-full max-w-md text-white text-center py-2 font-semibold text-lg mb-6">
    WeCare
  </div>

  <form method="POST" action="{{ route('otp.verify.registration') }}" autocomplete="off"
    class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6" spellcheck="false">
    @csrf
    @php
    $role = session('role');
  @endphp

    <h2 class="text-center text-black text-xl mb-6 font-medium">Masukkan Kode OTP</h2>

    @if ($role === 'organisasi')
    <p class="text-center text-black mb-6">Silakan masukkan OTP yang dikirim ke email organisasi Anda.</p>
  @else
    <p class="text-center text-black mb-6">Masukkan kode OTP yang dikirim ke email Anda.</p>
  @endif



    <label class="block text-black text-sm font-semibold mb-2 text-center">Kode OTP</label>
    <div class="flex justify-center gap-2 mb-4">
      @for ($i = 0; $i < 6; $i++)
      <input type="text" maxlength="1" class="otp-box" required>
    @endfor
    </div>
    <input type="hidden" name="otp" id="otp">

    <button type="submit"
      class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg mb-3 hover:bg-[#3a66d9] transition-colors">
      Verifikasi
    </button>
  </form>

  <form method="POST" action="{{ route('otp.resend') }}" class="text-center mt-2">
    @csrf
    <button type="submit" class="text-[#4A7CFD] font-semibold hover:underline">
      Kirim ulang kode OTP
    </button>
  </form>

  @if(session('success'))
    <p class="text-green-600 mt-2 text-center">{{ session('success') }}</p>
  @endif

  <script>
    const inputs = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('otp_code');

    inputs.forEach((input, idx) => {
      input.addEventListener('input', () => {
        if (input.value && idx < inputs.length - 1) {
          inputs[idx + 1].focus();
        }
        updateHiddenInput();
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && idx > 0) {
          inputs[idx - 1].focus();
        }
      });
    });

    function updateHiddenInput() {
      hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
    }
  </script>
</body>

</html>