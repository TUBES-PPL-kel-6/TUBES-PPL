@extends('layouts.app')

@section('content')
<div class="flex bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r p-6">
        <nav class="space-y-2">
            <a href="#" class="block py-2 px-4 rounded-lg text-[#8C1414] font-semibold bg-gray-100">Simpanan</a>
            <a href="#" class="block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100">Pinjaman</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#8C1414]">Semua Notifikasi</h2>
            <button class="px-4 py-2 bg-[#8C1414] text-white rounded hover:bg-[#641010]">Tandai semua telah dibaca</button>
        </div>
        <div class="bg-white rounded-lg shadow divide-y">
            <!-- Notifikasi 1 -->
            <div class="flex p-4 hover:bg-gray-50">
                <img src="https://img.icons8.com/color/48/000000/airplane-take-off.png" class="w-12 h-12 rounded mr-4" alt="icon">
                <div class="flex-1">
                    <div class="font-semibold text-[#8C1414]">Pengembalian Dana Disetujui Oleh Koperasi</div>
                    <div class="text-gray-700 text-sm mt-1">
                        Permintaan pengembalian dana #22082300UNXK1U41 telah disetujui secara otomatis oleh koperasi. Jika ada pembayaran yang tersisa akan dilepaskan kepadamu.
                    </div>
                    <div class="text-xs text-gray-400 mt-2">05/09/2022 18:58</div>
                </div>
            </div>
            <!-- Notifikasi 2 -->
            <div class="flex p-4 hover:bg-gray-50">
                <img src="https://img.icons8.com/color/48/000000/airplane-take-off.png" class="w-12 h-12 rounded mr-4" alt="icon">
                <div class="flex-1">
                    <div class="font-semibold text-[#8C1414]">Menunggu produk dari Anggota</div>
                    <div class="text-gray-700 text-sm mt-1">
                        Anggota akan mengembalikan produk untuk pengajuan pengembalian #220406172907774 ke alamatmu pada 06-09-2022.
                    </div>
                    <div class="text-xs text-gray-400 mt-2">07/09/2022 00:55</div>
                </div>
            </div>
            <!-- Notifikasi 3 -->
            <div class="flex p-4 hover:bg-gray-50">
                <img src="https://img.icons8.com/color/48/000000/airplane-take-off.png" class="w-12 h-12 rounded mr-4" alt="icon">
                <div class="flex-1">
                    <div class="font-semibold text-[#8C1414]">Permintaan Pengembalian</div>
                    <div class="text-gray-700 text-sm mt-1">
                        Anda telah mengajukan permintaan pengembalian dana. Silakan cek status pengembalian secara berkala.
                    </div>
                    <div class="text-xs text-gray-400 mt-2">07/09/2022 00:55</div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
