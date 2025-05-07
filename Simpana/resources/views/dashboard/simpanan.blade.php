@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Payment Type Options -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Simpanan</h1>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.simpanan.create', ['type' => 'wajib']) }}" class="px-4 py-2 rounded-md {{ request()->get('type') == 'wajib' ? 'bg-primary text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                    Simpanan Wajib
                </a>
                <a href="{{ route('dashboard.simpanan.create', ['type' => 'sukarela']) }}" class="px-4 py-2 rounded-md {{ request()->get('type') == 'sukarela' ? 'bg-primary text-white' : 'bg-red-700 hover: transition' }}">
                    Simpanan Sukarela
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Summary Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-1">{{ request()->get('type') == 'wajib' ? 'SIMPANAN wajib' : 'SUKARELA' }}</h2>
                
                <div class="grid grid-cols-2 gap-x-16 gap-y-2 mt-4">
                    <div>
                        <p class="text-sm text-gray-600">No rekening</p>
                        <p class="font-medium">{{ $accountNumber ?? '1000201DA10022' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal buka simpanan</p>
                        <p class="font-medium">{{ $openDate ?? '24 Jul 2024' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Suku jasa</p>
                        <p class="font-medium">{{ $interestRate ?? '0.5' }}%</p>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total simpanan</p>
                <p class="text-2xl font-bold text-primary">Rp{{ number_format($totalBalance ?? 4835207, 0, ',', '.') }}</p>
            </div>
        </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Riwayat Transaksi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Tanggal</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Keterangan</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Nominal</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions ?? [] as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $transaction->date }}</td>
                            <td class="py-3 px-4">{{ $transaction->description }}</td>
                            <td class="py-3 px-4 {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4">Rp{{ number_format($transaction->balance, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-4xl mb-2 opacity-30"></i>
                                    <p>Belum ada riwayat transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <!-- Pagination or show more button can go here -->
        </div>
    </div>
</div>
@endsection
