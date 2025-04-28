{{-- DASHBOARD --}}
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
     <!-- Font  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
     <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
 </head>
 <body class="flex bg-gray-50 text-gray-800 font-sans">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-primary text-white min-h-screen flex flex-col fixed shadow-lg z-10 transition-all duration-300 ease-in-out">
         <div class="p-4 font-bold text-2xl border-b border-white/20">
             <div class="flex items-center justify-start h-20">
                 <div class="flex items-center gap-0">
                     <img src="{{ asset('images/Simpana white.png') }}" alt="Simpana Logo" class="h-20 w-auto object-contain -ml-2 pt-3"> 
                     <span class="sidebar-text -ml-1">SIMPANA</span>
                 </div>
             </div>
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
             <!-- Dropdown Discussion & Feedback -->
             <div x-data="{ open: false }">
                 <button @click="open = !open" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-white/20 transition w-full">
                     <i class="fa-solid fa-comments"></i>
                     <span class="sidebar-text">Komunitas</span>
                     <i class="fa-solid fa-chevron-down ml-auto text-xs"></i>
                 </button>
                 <div x-show="open" class="space-y-1 mt-1 px-4">
                     <a href="/discussion" class="flex items-center gap-2 py-2 px-2 rounded-lg hover:bg-white/10 transition w-full">
                         <i class="fa-regular fa-comments"></i>
                         <span>Diskusi</span>
                     </a>
                     <a href="/feedback" class="flex items-center gap-2 py-2 px-2 rounded-lg hover:bg-white/10 transition w-full">
                         <i class="fa-regular fa-comment-dots"></i>
                         <span>Feedback</span>
                     </a>
                 </div>
             </div>
 
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
 
     <!-- Main -->
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
                 <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                         @if(Auth::check() && Auth::user()->ktp && file_exists(public_path('storage/ktp/' . Auth::user()->ktp)))
                             <img src="{{ asset('storage/ktp/' . Auth::user()->ktp) }}" alt="Foto Profil" class="w-8 h-8 object-cover rounded-full">
                         @elseif(Auth::check())
                             <span class="text-sm font-bold text-gray-600">{{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name, 0, 1)) }}</span>
                         @else
                             <span class="text-sm font-bold text-gray-600">?</span>
                         @endif
                     </div>
                     <span class="text-sm font-medium">
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
         // toggle sidebar
         document.getElementById('sidebar-toggle').addEventListener('click', function() {
             const sidebar = document.getElementById('sidebar');
             const mainContent = document.getElementById('main-content');
             const sidebarTexts = document.querySelectorAll('.sidebar-text');
 
             // Cek sidebar ketutup
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
                 // tutup sidebar
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
 
         // tes toggle screen yang beda ukuran
         document.getElementById('menu-toggle')?.addEventListener('click', function() {
             const sidebar = document.querySelector('aside');
             sidebar.classList.toggle('-translate-x-full');
         });
     </script>
 </body>
 </html>