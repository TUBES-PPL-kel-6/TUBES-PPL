@extends('layouts.app')

@section('content')
<div class="flex bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r p-6">
        <nav class="space-y-2">
            <a href="{{ route('notifications.general') }}" 
               class="block py-2 px-4 rounded-lg {{ request()->routeIs('notifications.general') ? 'text-[#8C1414] font-semibold bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                General
            </a>
            <a href="{{ route('notifications.simpanan') }}" 
               class="block py-2 px-4 rounded-lg {{ request()->routeIs('notifications.simpanan') ? 'text-[#8C1414] font-semibold bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                Simpanan
            </a>
            <a href="{{ route('notifications.pinjaman') }}" 
               class="block py-2 px-4 rounded-lg {{ request()->routeIs('notifications.pinjaman') ? 'text-[#8C1414] font-semibold bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                Pinjaman
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#8C1414]">
                @if(request()->routeIs('notifications.simpanan'))
                    Notifikasi Simpanan
                @elseif(request()->routeIs('notifications.pinjaman'))
                    Notifikasi Pinjaman
                @elseif(request()->routeIs('notifications.general'))
                    Notifikasi General
                @else
                    Notifikasi
                @endif
            </h2>
            <button class="px-4 py-2 bg-[#8C1414] text-white rounded hover:bg-[#641010]">Tandai semua telah dibaca</button>
        </div>
        <div class="bg-white rounded-lg shadow divide-y">
            @if(request()->routeIs('notifications.simpanan'))
                <!-- Notifikasi Simpanan -->
                <div class="flex p-4 hover:bg-gray-50">
                    <img src="https://img.icons8.com/color/48/000000/money-box.png" class="w-12 h-12 rounded mr-4" alt="icon">
                    <div class="flex-1">
                        <div class="font-semibold text-[#8C1414]">Simpanan Wajib Berhasil</div>
                        <div class="text-gray-700 text-sm mt-1">
                            Simpanan wajib Anda sebesar Rp 100.000 telah berhasil dicatat.
                        </div>
                        <div class="text-xs text-gray-400 mt-2">10/03/2024 14:30</div>
                    </div>
                </div>
                <div class="flex p-4 hover:bg-gray-50">
                    <img src="https://img.icons8.com/color/48/000000/deposit.png" class="w-12 h-12 rounded mr-4" alt="icon">
                    <div class="flex-1">
                        <div class="font-semibold text-[#8C1414]">Simpanan Pokok Diterima</div>
                        <div class="text-gray-700 text-sm mt-1">
                            Simpanan pokok Anda sebesar Rp 500.000 telah diterima.
                        </div>
                        <div class="text-xs text-gray-400 mt-2">09/03/2024 11:20</div>
                    </div>
                </div>
            @elseif(request()->routeIs('notifications.pinjaman'))
                <!-- Notifikasi Pinjaman -->
                <div class="flex p-4 hover:bg-gray-50">
                    <img src="https://img.icons8.com/color/48/000000/checked-2.png" class="w-12 h-12 rounded mr-4" alt="icon">
                    <div class="flex-1">
                        <div class="font-semibold text-green-600">Pinjaman Disetujui</div>
                        <div class="text-gray-700 text-sm mt-1">
                            Pinjaman Anda sebesar Rp 5.000.000 telah disetujui. Dana akan segera ditransfer ke rekening Anda.
                        </div>
                        <div class="text-xs text-gray-400 mt-2">10/03/2024 14:30</div>
                    </div>
                </div>
                <div class="flex p-4 hover:bg-gray-50">
                    <img src="https://img.icons8.com/color/48/000000/reminder.png" class="w-12 h-12 rounded mr-4" alt="icon">
                    <div class="flex-1">
                        <div class="font-semibold text-yellow-600">Pengingat Pembayaran</div>
                        <div class="text-gray-700 text-sm mt-1">
                            Jangan lupa untuk membayar cicilan pinjaman sebesar Rp 500.000 sebelum tanggal 15 Maret 2024.
                        </div>
                        <div class="text-xs text-gray-400 mt-2">12/03/2024 10:20</div>
                    </div>
                </div>
            @elseif(request()->routeIs('notifications.general'))
                <!-- Selalu tampilkan pesan selamat datang dengan style cantik -->
                <div class="flex p-4 hover:bg-gray-50">
                    <img src="https://img.icons8.com/color/48/000000/handshake.png" class="w-12 h-12 rounded mr-4" alt="icon">
                    <div class="flex-1">
                        <div class="font-semibold text-[#8C1414]">Selamat Datang!</div>
                        <div class="text-gray-700 text-sm mt-1">
                            Selamat datang di aplikasi <b>SIMPANA</b>! Semoga pengalaman Anda menyenangkan. Jangan lupa melakukan pembayaran simpanan/pinjaman Anda tepat waktu.
                        </div>
                        <div class="text-xs text-gray-400 mt-2">{{ now()->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <!-- Notifikasi General dari database -->
                @if(isset($notifications) && count($notifications))
                    @foreach($notifications as $notif)
                        <div class="flex p-4 hover:bg-gray-50">
                            <img src="https://img.icons8.com/color/48/000000/reminder.png" class="w-12 h-12 rounded mr-4" alt="icon">
                            <div class="flex-1">
                                <div class="font-semibold text-yellow-600">Notifikasi Umum</div>
                                <div class="text-gray-700 text-sm mt-1">
                                    {{ $notif->message }}
                                </div>
                                <div class="text-xs text-gray-400 mt-2">{{ $notif->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </main>
</div>
@endsection
