@extends('layouts.app')

@section('content')
<!-- Welcome -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ $user->nama ?? $user->name }}!</h1>
    <p class="text-gray-600">Berikut ringkasan keuangan Anda per tanggal {{ date('d F Y') }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- icon  -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-primary to-secondary shadow-md rounded-xl p-3">
            <i class="fa-solid fa-wallet text-white"></i>
        </div>

        <!-- Text  -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Total Simpanan</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp 53.250.000</h2>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <!-- Floating Icon -->
            <div class="absolute -top-4 left-4 bg-gradient-to-br from-green-600 to-green-800 shadow-md rounded-xl p-3">
                <i class="fa-solid fa-chart-line text-white"></i>
            </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-blue-600 to-blue-800 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-money-bill-wave text-white"></i>
        </div>

        <!-- Text -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Total Pinjaman</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp 15.000.000</h2>
        </div>

            <!-- Text Content -->
            <div class="text-right">
                <p class="text-gray-500 text-sm font-medium">Sisa Angsuran</p>
                <h2 class="text-3xl font-bold text-slate-800">12 <span class="text-lg">bulan</span></h2>
            </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-green-600 to-green-800 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-chart-line text-white"></i>
        </div>

        <!-- Text -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Keuntungan</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp 1.850.000</h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-green-500 font-semibold text-sm">+23%</span>
            <span class="text-gray-400 text-sm">dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-amber-500 to-amber-700 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-clock text-white"></i>
        </div>

        <!-- Text -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Sisa Angsuran</p>
            <h2 class="text-3xl font-bold text-slate-800">12 <span class="text-lg">bulan</span></h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-blue-500 font-semibold text-sm">On Track</span>
            <span class="text-gray-400 text-sm">jatuh tempo bulanan</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Transaksi Terbaru</h3>
            <button class="text-primary text-sm font-medium hover:underline">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3 font-medium">Transaksi</th>
                        <th class="pb-3 font-medium">Tanggal</th>
                        <th class="pb-3 font-medium">Jumlah</th>
                        <th class="pb-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-down text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Setor Simpanan</p>
                                    <p class="text-gray-500 text-xs">Transfer Bank</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">12 Apr 2025</td>
                        <td class="py-4 font-medium">+ Rp 1.500.000</td>
                        <td class="py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span></td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-up text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Bayar Angsuran</p>
                                    <p class="text-gray-500 text-xs">Auto Debit</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">05 Apr 2025</td>
                        <td class="py-4 font-medium">- Rp 850.000</td>
                        <td class="py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span></td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-down text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Setor Simpanan</p>
                                    <p class="text-gray-500 text-xs">Transfer Bank</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">01 Apr 2025</td>
                        <td class="py-4 font-medium">+ Rp 1.500.000</td>
                        <td class="py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-money-check text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Ambil Pinjaman</p>
                                    <p class="text-gray-500 text-xs">Pinjaman Baru</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">25 Mar 2025</td>
                        <td class="py-4 font-medium">+ Rp 15.000.000</td>
                        <td class="py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <button class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-money-bill-transfer text-primary"></i>
                    </div>
                    <span class="text-sm font-medium">Setor Simpanan</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-hand-holding-dollar text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium">Ajukan Pinjaman</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-receipt text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium">Bayar Angsuran</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-chart-pie text-amber-600"></i>
                    </div>
                    <span class="text-sm font-medium">Rencana Keuangan</span>
                </button>
            </div>
        </div>

        <!-- Notif -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Pemberitahuan</h3>
                <span class="bg-primary text-white text-xs rounded-full px-2 py-1">3 baru</span>
            </div>
            <div class="space-y-4">
                <div class="flex gap-3 p-3 border-l-4 border-primary bg-primary/5 rounded-r-lg">
                    <i class="fa-solid fa-circle-exclamation text-primary mt-1"></i>
                    <div>
                        <p class="font-medium text-sm">Pembayaran Angsuran Jatuh Tempo</p>
                        <p class="text-gray-500 text-xs">Dalam 3 hari</p>
                    </div>
                </div>
                <div class="flex gap-3 p-3 border-l-4 border-green-500 bg-green-50 rounded-r-lg">
                    <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                    <div>
                        <p class="font-medium text-sm">Setoran Bulanan Berhasil</p>
                        <p class="text-gray-500 text-xs">12 Apr 2025</p>
                    </div>
                </div>
                <div class="flex gap-3 p-3 border-l-4 border-blue-500 bg-blue-50 rounded-r-lg">
                    <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-medium text-sm">Program Simpanan Baru</p>
                        <p class="text-gray-500 text-xs">Lihat detail</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
