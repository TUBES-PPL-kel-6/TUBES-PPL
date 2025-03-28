<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simpana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #A94A4A 0%, #889E73 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .glass-effect {
            background: rgba(255, 246, 218, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(244, 215, 147, 0.3);
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(169, 74, 74, 0.1), 0 2px 4px -1px rgba(169, 74, 74, 0.06);
        }
        .custom-checkbox {
            accent-color: #A94A4A;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md flex-grow flex flex-col justify-center">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-[#FFF6DA] mb-2">Welcome Back</h1>
            <p class="text-[#FFF6DA]/90">Please sign in to your account</p>
        </div>

        <form action="#" method="POST" class="glass-effect shadow-xl rounded-2xl px-8 pt-8 pb-6">
            <div class="mb-6">
                <label class="block text-[#A94A4A] text-sm font-semibold mb-2" for="email">
                    Email Address
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border border-[#F4D793] rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-[#A94A4A] bg-white/80"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Enter your email"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-[#889E73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-[#A94A4A] text-sm font-semibold mb-2" for="password">
                    Password
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border border-[#F4D793] rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-[#A94A4A] bg-white/80"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-[#889E73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" class="custom-checkbox h-4 w-4 rounded border-[#F4D793]">
                    <label class="ml-2 block text-sm text-[#889E73]">Remember me</label>
                </div>
                <a class="text-sm font-semibold text-[#A94A4A] hover:text-[#889E73] transition-colors duration-200" href="#">
                    Forgot Password?
                </a>
            </div>

            <button
                class="w-full bg-gradient-to-r from-[#A94A4A] to-[#889E73] hover:from-[#889E73] hover:to-[#A94A4A] text-[#FFF6DA] font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]"
                type="submit">
                Sign In
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-[#889E73]">
                    Don't have an account? 
                    <a href="#" class="font-semibold text-[#A94A4A] hover:text-[#889E73] transition-colors duration-200">
                        Sign up
                    </a>
                </p>
            </div>
        </form>
    </div>

    <footer class="w-full text-center py-4 mt-auto">
        <p class="text-[#FFF6DA]/60 text-sm">
            &copy;2024 Simpana. All rights reserved.
        </p>
    </footer>
</body>
</html>
