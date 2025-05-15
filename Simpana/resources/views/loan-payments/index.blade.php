@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-6">Pembayaran Pinjaman</h1>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if ($loanApplications->isEmpty())
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <p class="text-gray-600">Anda tidak memiliki pinjaman yang aktif.</p>
    </div>
    @else
        @foreach ($loanApplications as $loan)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-medium">Pinjaman #{{ $loan->id }} - {{ ucfirst($loan->loan_product) }}</h2>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                    {{ ucfirst($loan->status) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pinjaman</p>
                    <p class="font-medium">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Tenor</p>
                    <p class="font-medium">{{ $loan->tenor }} Bulan</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Cicilan per Bulan</p>
                    <p class="font-medium">Rp {{ number_format($loan->getMonthlyInstallmentAmount(), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Angsuran Dibayar</p>
                    <p class="font-medium">{{ $loan->payments->where('status', 'paid')->count() }} dari {{ $loan->tenor }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Sisa Pinjaman</p>
                    <p class="font-medium">Rp {{ number_format($loan->getRemainingBalance(), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="font-medium mb-3">Riwayat Pembayaran</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Angsuran Ke</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan->payments as $payment)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3">{{ $payment->installment_number }}</td>
                                <td class="px-4 py-3">{{ $payment->due_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $payment->payment_method ? ucfirst($payment->payment_method) : '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if ($payment->status == 'paid' || $payment->status == 'verified') bg-green-100 text-green-800
                                        @elseif ($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                    
                                    @if ($payment->status == 'pending' && $payment->payment_date === null)
                                        <a href="{{ route('loan-payments.create', $loan->id) }}" 
                                           class="ml-2 px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                            Bayar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    @php
                        // Find the next payment that needs to be paid
                        $nextPayment = null;
                        foreach ($loan->payments as $payment) {
                            if ($payment->status === 'pending' && $payment->payment_date === null) {
                                $nextPayment = $payment;
                                break;
                            }
                        }
                    @endphp

                    @if ($nextPayment)
                        <a href="{{ route('loan-payments.create', $loan->id) }}" class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700">
                            Bayar Angsuran #{{ $nextPayment->installment_number }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection