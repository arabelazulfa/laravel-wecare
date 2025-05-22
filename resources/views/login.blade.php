<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            WeCare Login
        </title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap" rel="stylesheet"/>
        <style>
        body {font-family: "Poppins", sans-serif;}
        </style>
    </head>
    
    <body class="bg-[#FCE9E9] min-h-screen flex flex-col items-center pt-8 px-4">
        <div class="bg-[#F19494] rounded-lg w-full max-w-md text-white text-center py-2 font-semibold text-lg mb-6">
            WeCare
        </div>
        <form autocomplete="off" class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6" spellcheck="false">
            <h2 class="text-center text-black text-xl mb-6 font-medium">
                Masuk
            </h2>
            <label class="block text-black text-sm font-semibold mb-1" for="email">
                Email Address
            </label>
            <input class="w-full rounded-md py-2 px-3 mb-4 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F19494]" id="email" placeholder="Enter your email" required="" type="email"/>
            <label class="block text-black text-sm font-semibold mb-1" for="password">
                Password
            </label>
            <input class="w-full rounded-md py-2 px-3 mb-1 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F19494]" id="password" placeholder="Enter your password" required="" type="password"/>
            <div class="text-right text-xs text-black mb-4">
                <a href="reset-password.html" class="text-[#4A7CFD] font-semibold hover:underline">
                    Lupa password?
                </a>
            </div>
            
            <button class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg mb-3 hover:bg-[#3a66d9] transition-colors" type="submit">
                Masuk
            </button>
            <div class="text-center text-xs text-black mb-3">
                Atau masuk dengan
            </div>
            <button class="w-full bg-white rounded-md py-2 flex justify-center items-center gap-2" type="button">
                <img alt="Google logo" class="w-5 h-5" src="https://developers.google.com/identity/images/g-logo.png" width="20" height="20"/>

                <span class="text-sm text-black">
                    Google
                </span>
            </button>
            
            <p class="text-center text-xs text-black mt-4">
                Belum punya akun?
                <a class="text-[#4A7CFD] font-semibold hover:underline" href="daftar.blade.php">
                    Daftar
                </a>
            </p>
        </form>
    </body>
</html>