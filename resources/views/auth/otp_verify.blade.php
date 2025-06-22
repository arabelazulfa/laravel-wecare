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

  <div class="w-full">
    <div class="bg-[#F19494] text-white text-center py-4 rounded-xl shadow-md w-full mb-6">
      <h1 class="text-4xl font-bold tracking-wider uppercase">WeCare</h1>
    </div>
  </div>


  <form id="otp-verify-form" method="POST" action="{{ route('otp.verify.reset') }}"
    class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6" spellcheck="false">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">

    <h2 class="text-center text-black text-xl mb-6 font-medium">Masukkan Kode OTP</h2>
    <p class="text-center text-black mb-6">Masukkan kode OTP yang dikirim ke email Anda.</p>

    @if (session('status'))
      <div class="text-green-600 text-center mb-4 text-sm">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
        <ul class="text-sm list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <label class="block text-black text-sm font-semibold mb-2 text-center">Kode OTP</label>
    <div class="flex justify-center gap-2 mb-4">
      @for ($i = 0; $i < 6; $i++)
        <input type="text" maxlength="1" class="otp-box" required>
      @endfor
    </div>

    <input type="hidden" name="otp_code" id="otp_code">

    <button type="submit"
      class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg mb-3 hover:bg-[#3a66d9] transition-colors">
      Verifikasi
    </button>
  </form>

  <!-- Form Resend OTP -->
  <form method="POST" action="{{ route('otp.resend') }}" class="text-center mt-2">
    @csrf
    <button type="submit" class="text-[#4A7CFD] font-semibold hover:underline">
      Kirim ulang kode OTP
    </button>
  </form>

  <script>
    const inputs = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('otp_code');

    function updateHiddenInput() {
      hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
    }

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

    document.getElementById('otp-verify-form').addEventListener('submit', function () {
      updateHiddenInput();
    });
  </script>

</body>

</html>
