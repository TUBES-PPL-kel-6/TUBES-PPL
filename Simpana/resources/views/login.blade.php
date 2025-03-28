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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-white/80">Please sign in to your account</p>
        </div>

        <form action="#" method="POST" class="glass-effect shadow-xl rounded-2xl px-8 pt-8 pb-6">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                    Email Address
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Enter your email"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                    Password
                </label>
                <div class="relative">
                    <input
                        class="input-focus shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <a class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-200" href="#">
                    Forgot Password?
                </a>
            </div>

            <button
                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition-all duration-200 hover:scale-[1.02]"
                type="submit">
                Sign In
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="#" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-200">
                        Sign up
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-white/60 text-sm mt-6">
            &copy;2024 Simpana. All rights reserved.
        </p>
    </div>
</body>
</html>
