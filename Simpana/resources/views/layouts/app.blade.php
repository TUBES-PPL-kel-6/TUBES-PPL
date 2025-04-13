{{-- DASHBOARD --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simpana Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="flex bg-gray-50 text-gray-800 font-sans">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-primary text-white min-h-screen flex flex-col fixed shadow-lg z-10 transition-all duration-300 ease-in-out">
        <div class="p-6 font-bold text-2xl border-b border-white/20 flex items-center gap-2">
            <img src="{{ asset('images/LOGO Simpana.png') }}" alt="Simpana Logo" class="h-12 w-12"> <span class="sidebar-text">SIMPANA</span>
        </div>
        <nav class="flex-1 px-4 pt-6 space-y-1">
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-white text-primary font-medium transition">
                <i class="fa-solid fa-house-chimney"></i> <span class="sidebar-text">Dashboard</span>
            </a>
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-money-bill-trend-up"></i> <span class="sidebar-text">Riwayat Simpanan</span>
            </a>
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-money-bill-transfer"></i> <span class="sidebar-text">Setor Simpanan</span>
            </a>
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span class="sidebar-text">Pinjaman</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-xs uppercase font-bold text-white/60 sidebar-text">
                Akun
            </div>

            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-user"></i> <span class="sidebar-text">Profil</span>
            </a>
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-gear"></i> <span class="sidebar-text">Pengaturan</span>
            </a>
            <a href="" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-right-from-bracket"></i> <span class="sidebar-text">Keluar</span>
            </a>
        </nav>
        <div class="p-4 text-xs text-center opacity-70 border-t border-white/10 sidebar-text">© 2025 Simpana</div>
    </aside>

    <!-- Main content area -->
    <div id="main-content" class="flex-1 ml-64 min-h-screen flex flex-col transition-all duration-300 ease-in-out">

        <!-- Topbar -->
        <header class="flex items-center justify-between bg-white px-6 py-4 border-b border-gray-200 shadow-sm sticky top-0 z-5">
            <div class="flex items-center gap-2">
                <button id="sidebar-toggle" class="text-gray-500 hover:text-primary">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="text-sm text-gray-600">
                    <span class="text-gray-400">Pages</span> / <span class="text-primary font-semibold">Dashboard</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Search..." class="border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary pr-8">
                    <i class="fa-solid fa-search absolute right-3 top-2.5 text-gray-400"></i>
                </div>
                <div class="relative">
                    <button class="relative text-gray-500 hover:text-primary">
                        <i class="fa-solid fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <img src="/api/placeholder/40/40" alt="Avatar" class="h-8 w-8 rounded-full object-cover">
                    <span class="font-medium">John Doe</span>
                    <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white p-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© 2025 Simpana. All rights reserved.</p>
            <div class="mt-2 space-x-4">
                <a href="#" class="hover:text-primary">Bantuan</a>
                <a href="#" class="hover:text-primary">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-primary">Kebijakan Privasi</a>
            </div>
        </footer>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            // Check if sidebar is collapsed
            const isCollapsed = sidebar.classList.contains('w-16');

            if (isCollapsed) {
                // Expand sidebar
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('ml-16');
                mainContent.classList.add('ml-64');

                // Show text
                sidebarTexts.forEach(text => {
                    text.classList.remove('hidden');
                });
            } else {
                // Collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-16');

                // Hide text
                sidebarTexts.forEach(text => {
                    text.classList.add('hidden');
                });
            }
        });

        // Mobile menu toggle for smaller screens
        document.getElementById('menu-toggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
