<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simpana Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans" x-data="{ sidebarOpen: true, sidebarCollapsed: false }">
    <!-- Mobile Menu Overlay -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
         @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
           :class="sidebarCollapsed ? 'w-16' : 'w-64'"
           class="fixed left-0 top-0 z-30 h-full bg-primary text-white transition-all duration-300 ease-in-out shadow-xl
                  lg:translate-x-0"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <!-- Logo Section -->
        <div class="flex items-center p-4 border-b border-white/20 h-20">
            <div class="flex items-center gap-0" :class="sidebarCollapsed ? 'justify-center' : 'justify-start'">
                <img src="{{ asset('images/Simpana white.png') }}" alt="Simpana Logo"
                     :class="sidebarCollapsed ? 'h-10 w-10' : 'h-20 w-auto'"
                     class="object-contain -ml-2 pt-3 transition-all duration-300">
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text -ml-1 font-bold text-2xl">SIMPANA</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 pt-6 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg bg-white text-primary font-medium transition-all duration-200 hover:bg-white/90">
                <i class="fa-solid fa-house-chimney" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Dashboard</span>
            </a>

            <!-- Savings Links -->
            <a href="{{ route('dashboard.simpanan') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-money-bill-trend-up" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Riwayat Simpanan</span>
            </a>

            <a href="{{ route('dashboard.simpanan.create') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-money-bill-transfer" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Setor Simpanan</span>
            </a>

            <!-- Loan Links -->
            <a href="{{ route('loan.create') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-file-invoice-dollar" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Pinjaman</span>
            </a>

            <a href="{{ route('loan-payments.index') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-money-check-dollar" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Pembayaran Pinjaman</span>
            </a>

            <!-- Community Dropdown -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200 w-full">
                    <i class="fa-solid fa-comments" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                    <span x-show="!sidebarCollapsed" x-transition class="sidebar-text flex-1 text-left">Komunitas</span>
                    <i x-show="!sidebarCollapsed && open" x-transition class="fa-solid fa-chevron-up ml-auto text-xs"></i>
                    <i x-show="!sidebarCollapsed && !open" x-transition class="fa-solid fa-chevron-down ml-auto text-xs"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="space-y-1 mt-1 px-4">
                    <a href="/discussion"
                       class="flex items-center gap-2 py-2 px-2 rounded-lg hover:bg-white/10 transition-all duration-200 w-full">
                        <i class="fa-regular fa-comments"></i>
                        <span>Diskusi</span>
                    </a>
                    <a href="/complaint"
                       class="flex items-center gap-2 py-2 px-2 rounded-lg hover:bg-white/10 transition-all duration-200 w-full">
                        <i class="fa-regular fa-comment-dots"></i>
                        <span>Feedback</span>
                    </a>
                </div>
            </div>

            <!-- Account Section -->
            <div class="pt-4 pb-2 px-4" x-show="!sidebarCollapsed" x-transition>
                <div class="text-xs uppercase font-bold text-white/60 sidebar-text">
                    Akun
                </div>
            </div>

            <a href="{{ route('dashboard.profile') }}"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-user" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Profil</span>
            </a>

            <a href="#"
               class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200">
                <i class="fa-solid fa-gear" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Pengaturan</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200 w-full">
                    <i class="fa-solid fa-right-from-bracket" :class="sidebarCollapsed ? 'text-center' : ''"></i>
                    <span x-show="!sidebarCollapsed" x-transition class="sidebar-text">Keluar</span>
                </button>
            </form>
        </nav>

        <!-- Footer -->
        <div x-show="!sidebarCollapsed" x-transition
             class="p-4 text-xs text-center opacity-70 border-t border-white/10 sidebar-text">
            © 2025 Simpana
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content"
         :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'"
         class="min-h-screen flex flex-col transition-all duration-300 ease-in-out">

        <!-- Header -->
        <header class="flex items-center justify-between bg-white px-6 py-4 border-b border-gray-200 shadow-sm sticky top-0 z-10">
            <!-- Left Side -->
            <div class="flex items-center gap-4">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden text-gray-500 hover:text-primary transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Desktop sidebar toggle -->
                <button id="sidebar-toggle"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden lg:block text-gray-500 hover:text-primary transition-colors">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Breadcrumb -->
                <div class="text-sm text-gray-600">
                    <span class="text-gray-400">Pages</span> / <span class="text-primary font-semibold">Dashboard</span>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div class="relative">
                    <a href="{{ route('notifications') }}" class="relative text-gray-500 hover:text-primary transition-colors">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                    @if(isset($unreadNotificationCount) && $unreadNotificationCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                            {{ $unreadNotificationCount }}
                        </span>
                    @endif
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if(Auth::check() && Auth::user()->ktp && file_exists(public_path('storage/ktp/' . Auth::user()->ktp)))
                            <img src="{{ asset('storage/ktp/' . Auth::user()->ktp) }}" alt="Foto Profil" class="w-8 h-8 object-cover rounded-full">
                        @elseif(Auth::check())
                            <span class="text-sm font-bold text-gray-600">{{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name, 0, 1)) }}</span>
                        @else
                            <span class="text-sm font-bold text-gray-600">?</span>
                        @endif
                    </div>
                    <span class="text-sm font-medium hidden sm:block">
                        {{ Auth::check() ? (Auth::user()->nama ?? Auth::user()->name) : '' }}
                    </span>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        // Fallback for non-Alpine environments
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (sidebarToggle && !window.Alpine) {
                sidebarToggle.addEventListener('click', function() {
                    const isCollapsed = sidebar.classList.contains('w-16');

                    if (isCollapsed) {
                        sidebar.classList.remove('w-16');
                        sidebar.classList.add('w-64');
                        mainContent.classList.remove('lg:ml-16');
                        mainContent.classList.add('lg:ml-64');
                    } else {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-16');
                        mainContent.classList.remove('lg:ml-64');
                        mainContent.classList.add('lg:ml-16');
                    }
                });
            }
        });
    </script>
</body>
</html>
