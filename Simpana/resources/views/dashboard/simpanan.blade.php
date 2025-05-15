@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('info'))
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
        <p>{{ session('info') }}</p>
    </div>
    @endif

    <!-- Header with Payment Type Options -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Simpanan</h1>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.simpanan.create', ['type' => 'wajib']) }}" 
                   class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 {{ isset($currentMonthWajib) ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Simpanan Wajib
                </a>
                <a href="{{ route('dashboard.simpanan.create', ['type' => 'sukarela']) }}" 
                   class="px-4 py-2 rounded-md bg-red-700 text-white hover:bg-red-800 transition">
                    Simpanan Sukarela
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Summary Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-1">{{ $user->nama }}</h2>
                
                <div class="grid grid-cols-2 gap-x-16 gap-y-2 mt-4">
                    <div>
                        <p class="text-sm text-gray-600">No.Handphone</p>
                        <p class="font-medium">{{ $user->no_telp }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal buka simpanan</p>
                        <p class="font-medium">{{ $tanggalBuka ? $tanggalBuka->format('d M Y') : 'Belum ada' }}</p>
                    </div>
                    <div class="mt-2 text-sm">
                    <div class="flex items-center">
                        <span class="mr-2">Simpanan Wajib Bulan Ini:</span>
                        @if(isset($currentMonthWajib))
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                Sudah Dibayar
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                Belum Dibayar
                            </span>
                        @endif
                    </div>
                </div>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total simpanan</p>
                <p class="text-2xl font-bold text-primary">Rp{{ number_format($totalSimpanan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Riwayat Simpanan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Tanggal</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Jenis</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Keterangan</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($simpanans as $simpanan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $simpanan->tanggal->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">{{ ucfirst($simpanan->jenis_simpanan) }}</td>
                            <td class="py-3 px-4">{{ $simpanan->keterangan ?: 'Setoran Simpanan' }}</td>
                            <td class="py-3 px-4 text-green-600">
                                Rp{{ number_format($simpanan->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-4xl mb-2 opacity-30"></i>
                                    <p>Belum ada riwayat simpanan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection