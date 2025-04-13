@extends('layouts.app')

@section('content')
<!-- Welcome Section -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ $user->name }}!</h1>
    <p class="text-gray-600">Berikut ringkasan keuangan Anda per {{ now()->format('d F Y') }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Floating Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-primary to-secondary shadow-md rounded-xl p-3">
            <i class="fa-solid fa-wallet text-white"></i>
        </div>

        <!-- Text Content -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Total Simpanan</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalSimpananPokok + $totalSimpananWajib + $totalSimpananSukarela, 0, ',', '.') }}</h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-green-500 font-semibold text-sm">+12%</span>
            <span class="text-gray-400 text-sm">dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Floating Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-blue-600 to-blue-800 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-money-bill-wave text-white"></i>
        </div>

        <!-- Text Content -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Simpanan Pokok</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalSimpananPokok, 0, ',', '.') }}</h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-green-500 font-semibold text-sm">+5%</span>
            <span class="text-gray-400 text-sm">dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Floating Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-green-600 to-green-800 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-piggy-bank text-white"></i>
        </div>

        <!-- Text Content -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Simpanan Wajib</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalSimpananWajib, 0, ',', '.') }}</h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-green-500 font-semibold text-sm">+8%</span>
            <span class="text-gray-400 text-sm">dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
        <!-- Floating Icon -->
        <div class="absolute -top-4 left-4 bg-gradient-to-br from-purple-600 to-purple-800 shadow-md rounded-xl p-3">
            <i class="fa-solid fa-hand-holding-dollar text-white"></i>
        </div>

        <!-- Text Content -->
        <div class="text-right">
            <p class="text-gray-500 text-sm font-medium">Simpanan Sukarela</p>
            <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalSimpananSukarela, 0, ',', '.') }}</h2>
        </div>

        <div class="mt-4 text-right">
            <span class="text-green-500 font-semibold text-sm">+15%</span>
            <span class="text-gray-400 text-sm">dari bulan lalu</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Transactions -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Transaksi Terbaru</h3>
            <a href="{{ route('dashboard.transactions') }}" class="text-primary text-sm font-medium hover:underline">Lihat Semua</a>
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
                <tbody>
                    @forelse($transaksiTerbaru as $transaksi)
                    <tr class="border-b">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                    <i class="fa-solid fa-money-bill-transfer text-primary"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ ucfirst($transaksi->jenis_transaksi) }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaksi->keterangan }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-gray-600">{{ $transaksi->tanggal->format('d M Y') }}</td>
                        <td class="py-4 font-medium {{ $transaksi->jenis_transaksi === 'setor' ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $transaksi->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($transaksi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('dashboard.simpanan.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-money-bill-transfer text-primary"></i>
                    </div>
                    <span class="text-sm font-medium">Setor Simpanan</span>
                </a>
                <a href="{{ route('dashboard.simpanan') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-hand-holding-dollar text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium">Lihat Simpanan</span>
                </a>
                <a href="{{ route('dashboard.transactions') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-receipt text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium">Riwayat Transaksi</span>
                </a>
                <a href="{{ route('dashboard.profile') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-user text-amber-600"></i>
                    </div>
                    <span class="text-sm font-medium">Profil</span>
                </a>
            </div>
        </div>

        <!-- Notifications -->
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
