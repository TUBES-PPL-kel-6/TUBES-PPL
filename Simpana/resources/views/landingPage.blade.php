<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Simpana') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .gradient-background {
            background: linear-gradient(135deg, #873434 0%, #B94D4D 40%, #F3D38B 100%);
            position: relative;
            overflow: hidden;
        }

        .overlay-pattern {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 100%),
                        radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }

        /* .glass-nav {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        } */

        .btn-primary {
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }

        .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.25);
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease;
        }
    </style>
</head>
<body class="gradient-background min-h-screen font-['Plus_Jakarta_Sans'] relative">
    <div class="overlay-pattern"></div>

    <!-- NAV -->
    <nav class="glass-nav sticky top-0 z-50 py-2 px-6 flex justify-between items-center">
        <img src="{{ asset('images/Simpana white.png') }}" alt="Logo" class="h-20 w-auto transition-transform hover:scale-100">
        <button id="contactBtn" class="bg-white text-[#873434] px-4 py-2 rounded-lg font-semibold hover:bg-[#FFDFA8] transition-all shadow-md hover:shadow-lg flex items-center text-sm focus:outline-none">
            <i class="fas fa-envelope text-lg mr-2"></i>Hubungi Kami
        </button>
    </nav>

    <!-- Main -->
    <div class="container mx-auto px-4 sm:px-6 md:px-12 lg:px-24 relative z-10">
        <div class="flex items-start justify-between py-16">
            <div class="max-w-2xl">
                <div class="flex items-center mb-6">
                    <h1 class="text-5xl font-bold text-white leading-tight">
                        Simpana
                    </h1>
                    <i class="fas fa-shield-alt text-4xl text-[#FFDFA8] ml-4"></i>
                </div>

                <p class="text-2xl text-white mb-4 font-medium leading-relaxed">
                    Sistem Informasi Manajemen<br>Koperasi Simpan Pinjam
                </p>

                <p class="text-lg text-white/90 mb-8 leading-relaxed">
                    Kelola simpanan dan pinjaman Anda dengan sistem yang aman,
                    terpercaya, dan mudah digunakan.
                </p>

                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="btn-primary bg-[#7A2E2E] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#6A2828] transition-all inline-flex items-center text-sm">
                        <i class="fas fa-user-plus text-lg mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn-primary bg-white/20 text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/30 transition-all backdrop-blur-sm inline-flex items-center border border-white/30 text-sm">
                        <i class="fas fa-sign-in-alt text-lg mr-2"></i>
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Us Modal -->
    <div id="contactModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 relative animate-fade-in">
            <button onclick="closeContactModal()" class="absolute top-3 right-3 text-gray-400 hover:text-[#873434] text-xl focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h2 class="text-2xl font-bold text-[#873434] mb-2">Contact Us</h2>
            <form class="space-y-4 mt-2">
                <div>
                    <label class="block text-[#873434] text-sm font-semibold mb-1">Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#873434] focus:ring-1 focus:ring-[#873434] transition" placeholder="Name" required>
                </div>
                <div>
                    <label class="block text-[#873434] text-sm font-semibold mb-1">Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#873434] focus:ring-1 focus:ring-[#873434] transition" placeholder="Email" required>
                </div>
                <div>
                    <label class="block text-[#873434] text-sm font-semibold mb-1">Phone</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#873434] focus:ring-1 focus:ring-[#873434] transition" placeholder="Phone" required>
                </div>
                <div>
                    <label class="block text-[#873434] text-sm font-semibold mb-1">Message</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#873434] focus:ring-1 focus:ring-[#873434] transition resize-none" placeholder="Your message..." rows="3" required></textarea>
                </div>
                <button type="submit" class="w-full bg-[#87CE45] hover:bg-[#6fa83a] text-white font-semibold py-2 rounded-lg transition-all">Submit</button>
            </form>
        </div>
    </div>

    <script>
        const contactBtn = document.getElementById('contactBtn');
        const contactModal = document.getElementById('contactModal');

        contactBtn.addEventListener('click', function() {
            contactModal.classList.remove('hidden');
        });

        function closeContactModal() {
            contactModal.classList.add('hidden');
        }

        // Optional: close modal when clicking outside the form
        contactModal?.addEventListener('click', function(e) {
            if (e.target === contactModal) {
                closeContactModal();
            }
        });
    </script>
</body>
</html>
