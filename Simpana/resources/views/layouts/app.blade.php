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
    <aside class="w-64 bg-primary text-white h-screen fixed left-0 top-0 flex flex-col">
        <div class="p-4">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-landmark"></i> SIMPANA
            </h1>
        </div>
        <div class="flex-1 px-4 pt-6 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-white text-primary font-medium transition">
                <i class="fa-solid fa-house-chimney"></i> <span class="sidebar-text">Dashboard</span>
            </a>
            <a href="{{ route('dashboard.simpanan') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-money-bill-trend-up"></i> <span class="sidebar-text">Riwayat Simpanan</span>
            </a>
            <a href="{{ route('dashboard.simpanan.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-money-bill-transfer"></i> <span class="sidebar-text">Setor Simpanan</span>
            </a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span class="sidebar-text">Pinjaman</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-xs uppercase font-bold text-white/60 sidebar-text">
                Akun
            </div>

            <a href="{{ route('dashboard.profile') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-user"></i> <span class="sidebar-text">Profil</span>
            </a>
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition">
                <i class="fa-solid fa-gear"></i> <span class="sidebar-text">Pengaturan</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition w-full">
                    <i class="fa-solid fa-right-from-bracket"></i> <span class="sidebar-text">Keluar</span>
                </button>
            </form>
        </div>
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
                    <button class="text-gray-500 hover:text-primary">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-sm font-bold text-gray-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        // Sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('aside').classList.toggle('-translate-x-full');
            document.getElementById('main-content').classList.toggle('ml-0');
        });
    </script>
</body>
</html>
