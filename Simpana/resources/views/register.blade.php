<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Simpana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8C1414',
                        secondary: '#641010',
                        gold: '#FFD500',
                        greenish: '#87CE45',
                        white: '#FFFFFF'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f1f1;
            min-height: 100vh;
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(140, 20, 20, 0.1), 0 2px 4px -1px rgba(140, 20, 20, 0.06);
        }
    </style>
    <script>
        function nextStep() {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("password_confirmation").value;

            if (!email || !password || !confirmPassword) {
                alert("Harap isi email dan password sebelum melanjutkan.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Konfirmasi password tidak cocok.");
                return;
            }

            document.getElementById("emailHidden").value = email;
            document.getElementById("passwordHidden").value = password;
            document.getElementById("passwordConfirmationHidden").value = confirmPassword;

            document.getElementById("emailForm").style.display = "none";
            document.getElementById("dataDiriForm").style.display = "block";
        }

        function prevStep() {
            document.getElementById("dataDiriForm").style.display = "none";
            document.getElementById("emailForm").style.display = "block";
        }

        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Check if we need to show step 2 on page load (if there are validation errors)
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->any() && (old('nama') || old('alamat') || old('no_telp') || old('nik')))
                // If there are validation errors and step 2 data exists, show step 2
                // Use session data for passwords
                document.getElementById("email").value = "{{ session('temp_email', old('email')) }}";
                document.getElementById("password").value = "{{ session('temp_password') }}";
                document.getElementById("password_confirmation").value = "{{ session('temp_password_confirmation') }}";

                document.getElementById("emailHidden").value = "{{ session('temp_email', old('email')) }}";
                document.getElementById("passwordHidden").value = "{{ session('temp_password') }}";
                document.getElementById("passwordConfirmationHidden").value = "{{ session('temp_password_confirmation') }}";

                document.getElementById("emailForm").style.display = "none";
                document.getElementById("dataDiriForm").style.display = "block";
            @endif
        });
    </script>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md flex-grow flex flex-col justify-center">
        <div class="text-center mb-5">
            <div class="flex justify-center items-center gap-0 mb-1">
                <img src="{{ asset('images/Simpana red.png') }}" alt="Simpana Logo" class="h-20 w-auto object-contain -ml-2 pt-1">
                <span class="text-4xl font-bold text-primary -ml-1">SIMPANA</span>
            </div>
            <p class="text-gray-600 text-base">Please sign in to your account</p>
        </div>

        {{-- Feedback Pesan --}}
        @if(session('success'))
            <div class="bg-greenish text-white p-4 rounded-lg mb-6" role="alert">
                {{ session('success') }}
                <button type="button" class="float-right" onclick="this.parentElement.style.display='none'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="float-right" onclick="this.parentElement.style.display='none'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Email & Password -->
        <form id="emailForm" onsubmit="event.preventDefault(); nextStep();" class="bg-white shadow-xl rounded-2xl px-8 pt-8 pb-6 border border-gray-200">
            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Email:</label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ session('temp_email', old('email')) }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Password:</label>
                <div class="relative">
                    <input type="password" id="password" name="password" value="{{ session('temp_password') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary pr-12" required minlength="6">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none" tabindex="-1">
                        <i class="fa-solid fa-eye text-gray-400"></i>
                    </button>
                </div>
                <span class="text-xs text-gray-500 mt-1 block">Password minimal 6 karakter</span>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Konfirmasi Password:</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{ session('temp_password_confirmation') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary pr-12" required minlength="6">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none" tabindex="-1">
                        <i class="fa-solid fa-eye text-gray-400"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]">
                <i class="fa-solid fa-arrow-right mr-2"></i> Lanjut
            </button>
        </form>

        <!-- Data Diri -->
        <form id="dataDiriForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-2xl px-8 pt-8 pb-6 border border-gray-200 mt-6" style="display: none;">
            @csrf
            <!-- Hidden email & password -->
            <input type="hidden" name="email" id="emailHidden" value="{{ session('temp_email', old('email')) }}">
            <input type="hidden" name="password" id="passwordHidden" value="{{ session('temp_password') }}">
            <input type="hidden" name="password_confirmation" id="passwordConfirmationHidden" value="{{ session('temp_password_confirmation') }}">

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Nama:</label>
                <div class="relative">
                    <input type="text" name="nama" value="{{ old('nama') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Alamat:</label>
                <div class="relative">
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-location-dot text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Nomor Telepon:</label>
                <div class="relative">
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-phone text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">NIK:</label>
                <div class="relative">
                    <input type="text" name="nik" value="{{ old('nik') }}" class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-id-card text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2">Upload KTP:</label>
                <input type="file" name="ktp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-secondary" accept=".jpg,.jpeg,.png,.pdf" required>
                @if($errors->has('ktp'))
                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('ktp') }}</span>
                @endif
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="prevStep()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </button>
                <button type="submit" class="flex-1 bg-greenish hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]">
                    <i class="fa-solid fa-check mr-2"></i> Kirim
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-secondary transition-colors duration-200">
                    Masuk
                </a>
            </p>
        </div>
    </div>


</body>
</html>
