<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simpana</title>
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
            display: flex;
            flex-direction: column;
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(140, 20, 20, 0.1), 0 2px 4px -1px rgba(140, 20, 20, 0.06);
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md flex-grow flex flex-col justify-center">
        <div class="text-center mb-5">
            <div class="flex justify-center items-center gap-0 mb-1">
                <img src="{{ asset('images/Simpana red.png') }}" alt="Simpana Logo" class="h-20 w-auto object-contain -ml-2 pt-3">
                <span class="text-4xl font-bold text-primary -ml-1">SIMPANA</span>
            </div>
            <p class="text-gray-600 text-base">Please sign in to your account</p>
        </div>


        <form action="/login" method="POST" class="bg-white shadow-xl rounded-2xl px-8 pt-8 pb-6 border border-gray-200">
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            <div class="mb-6">
                <label class="block text-primary text-sm font-semibold mb-2" for="email">
                    Email Address
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Enter your email"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-primary text-sm font-semibold mb-2" for="password">
                    Password
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary pr-12"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        required
                    >
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none" tabindex="-1">
                        <i class="fa-solid fa-eye text-gray-400"></i>
                    </button>
                </div>
            </div>

            <button
                class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]"
                type="submit">
                Sign In
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-secondary transition-colors duration-200">
                        Sign up
                    </a>
                </p>
            </div>
        </form>
    </div>

    <footer class="w-full text-center py-4 mt-auto text-gray-500 text-sm">
        <p>&copy; 2025 Simpana. All rights reserved.</p>
        <div class="mt-2 space-x-4">
            <a href="#" class="hover:text-primary">Bantuan</a>
            <a href="#" class="hover:text-primary">Syarat & Ketentuan</a>
            <a href="#" class="hover:text-primary">Kebijakan Privasi</a>
        </div>
    </footer>

    <script>
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
    </script>
</body>
</html>
