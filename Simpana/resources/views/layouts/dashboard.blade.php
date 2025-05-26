@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
    <p class="text-gray-600">Berikut ringkasan keuangan Anda per tanggal {{ now()->format('d M Y') }}</p>
</div>

<!-- Stats Cards -->
<div class="w-full overflow-x-auto px-2">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 min-w-[600px]">
        <!-- Total Simpanan -->
        <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <div class="absolute -top-4 left-4 bg-gradient-to-br from-primary to-secondary shadow-md rounded-xl p-3">
                <i class="fa-solid fa-wallet text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm font-medium">Total Simpanan</p>
                <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
        <!-- Total Pinjaman -->
        <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <div class="absolute -top-4 left-4 bg-gradient-to-br from-blue-600 to-blue-800 shadow-md rounded-xl p-3">
                <i class="fa-solid fa-money-bill-wave text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm font-medium">Total Pinjaman</p>
                <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalPinjaman ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
        <!-- SHU -->
        <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <div class="absolute -top-4 left-4 bg-gradient-to-br from-green-600 to-green-800 shadow-md rounded-xl p-3">
                <i class="fa-solid fa-chart-line text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm font-medium">SHU</p>
                <h2 class="text-3xl font-bold text-slate-800">Rp {{ number_format($shu ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
        <!-- Sisa Angsuran -->
        <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <div class="absolute -top-4 left-4 bg-gradient-to-br from-amber-500 to-amber-700 shadow-md rounded-xl p-3">
                <i class="fa-solid fa-clock text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm font-medium">Sisa Angsuran</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $sisaAngsuran ?? 0 }} <span class="text-lg">pinjaman</span></h2>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions and Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Transactions -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Transaksi Terbaru</h3>
            <a href="{{ route('dashboard.simpanan') }}" class="text-primary text-sm font-medium hover:underline">Lihat Semua</a>
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
                    @forelse($recentTransactions ?? [] as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $trx->type == 'debit' ? 'bg-red-100' : 'bg-green-100' }} flex items-center justify-center">
                                    <i class="fa-solid {{ $trx->type == 'debit' ? 'fa-arrow-up text-red-600' : 'fa-arrow-down text-green-600' }}"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $trx->description }}</p>
                                    <p class="text-gray-500 text-xs">{{ $trx->method }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="py-4 font-medium">
                            {{ $trx->type == 'debit' ? '-' : '+' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="py-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">{{ ucfirst($trx->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-400 py-6">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions and Notifications -->
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
                <a href="{{ route('loan.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-hand-holding-dollar text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium">Ajukan Pinjaman</span>
                </a>
                <a href="{{ route('loan-payments.index') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-receipt text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium">Bayar Angsuran</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fa-solid fa-chart-pie text-amber-600"></i>
                    </div>
                    <span class="text-sm font-medium">Rencana Keuangan</span>
                </a>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Pemberitahuan</h3>
                <a href="{{ route('notifications') }}" class="bg-primary text-white text-xs rounded-full px-2 py-1 hover:bg-secondary transition">
                    {{ $unreadNotifications ?? 0 }} baru
                </a>
            </div>
            <div class="space-y-4">
                @forelse($recentNotifications ?? [] as $notif)
                <div class="flex gap-3 p-3 border-l-4 border-primary bg-primary/5 rounded-r-lg">
                    <i class="fa-solid fa-circle-exclamation text-primary mt-1"></i>
                    <div>
                        <p class="font-medium text-sm">{{ $notif->title ?? '-' }}</p>
                        <p class="text-gray-500 text-xs">{{ $notif->message }}</p>
                        <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-gray-400 text-sm">Tidak ada pemberitahuan baru.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    confirmButtonColor: '#8C1414'
  });
</script>
@endif
@endsection
