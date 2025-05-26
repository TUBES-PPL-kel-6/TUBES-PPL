@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-6xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pembayaran Pinjaman</h1>
    </div>

    @if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    @if ($loanApplications->isEmpty())
    <div class="text-center py-16">
        <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-medium text-gray-700 mb-2">Tidak Ada Pinjaman Aktif</h3>
        <p class="text-gray-500">Anda belum memiliki pinjaman yang perlu dibayar.</p>
    </div>
    @else
        @php
            $sortedLoans = $loanApplications->sortBy(function($loan) {
                // Hitung total pembayaran lunas
                $totalPaid = $loan->payments->whereIn('status', ['verified', 'paid'])->sum('amount');
                // Jika sudah lunas, beri nilai 1 (bawah), jika belum lunas beri 0 (atas)
                return $totalPaid >= $loan->loan_amount ? 1 : 0;
            })->values();
        @endphp

        @foreach ($sortedLoans as $loan)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-white">{{ ucfirst($loan->loan_product) }}</h2>
                        <p class="text-red-100 text-sm">Pinjaman #{{ $loan->id }}</p>
                    </div>
                    <span class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-full text-sm font-medium backdrop-blur-sm">
                        {{ ucfirst($loan->status) }}
                    </span>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="p-6 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Total Pinjaman</p>
                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Cicilan/Bulan</p>
                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($loan->getMonthlyInstallmentAmount(), 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Progress</p>
                        @php
                            $totalPaid = $loan->payments->whereIn('status', ['verified', 'paid'])->sum('amount');
                            $isFullyPaid = $totalPaid >= $loan->loan_amount;
                            $progressPercentage = min(($totalPaid / $loan->loan_amount) * 100, 100);
                        @endphp
                        @if ($isFullyPaid)
                            <p class="text-lg font-bold text-green-600 mr-2">Lunas</p>
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        @else
                            <p class="text-lg font-bold text-gray-900 mr-2">
                                {{ number_format($totalPaid, 0, ',', '.') }} / {{ number_format($loan->loan_amount, 0, ',', '.') }}
                            </p>
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Sisa Pinjaman</p>
                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($loan->getRemainingBalance(), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            @if (!$isFullyPaid)
                <!-- Payment Schedule -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Jadwal Pembayaran</h3>
                        @php
                            $nextUnpaidPayment = $loan->payments()
                                ->whereNull('payment_date')
                                ->where('status', 'pending')
                                ->orderBy('installment_number')
                                ->first();
                        @endphp
                        @if ($nextUnpaidPayment)
                            <a href="{{ route('loan-payments.create', $loan->id) }}"
                               class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Bayar Angsuran #{{ $nextUnpaidPayment->installment_number }}
                            </a>
                        @else
                            <span class="px-4 py-2 bg-green-100 text-green-800 font-medium rounded-lg">
                                🎉 Lunas
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @php
                            // Group by installment_number, ambil yang statusnya sudah lunas jika ada, kalau tidak ambil yang pending
                            $uniquePayments = $loan->payments
                                ->sortBy('installment_number')
                                ->groupBy('installment_number')
                                ->map(function($group) {
                                    // Cari yang sudah lunas
                                    $paid = $group->firstWhere('status', 'verified') ?? $group->firstWhere('status', 'paid');
                                    // Kalau tidak ada, ambil yang pending
                                    return $paid ?? $group->first();
                                })
                                // Urutkan: pending di atas, lunas di bawah
                                ->sortBy(function($payment) {
                                    return in_array($payment->status, ['verified', 'paid']) ? 1 : 0;
                                })
                                ->values();
                        @endphp
                        @foreach ($uniquePayments as $payment)
                        <div class="border rounded-lg p-4 {{ $payment->status === 'verified' || $payment->status === 'paid' ? 'bg-green-50 border-green-200' : ($payment->status === 'pending' && $payment->payment_date ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200') }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-600">Angsuran #{{ $payment->installment_number }}</span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if ($payment->status === 'verified' || $payment->status === 'paid')
                                        bg-green-100 text-green-800
                                    @elseif ($payment->status === 'pending' && $payment->payment_date)
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-gray-100 text-gray-600
                                    @endif">
                                    @if ($payment->status === 'verified' || $payment->status === 'paid')
                                        ✓ Lunas
                                    @elseif ($payment->status === 'pending' && $payment->payment_date)
                                        ⏳ Menunggu
                                    @else
                                        ○ Belum Bayar
                                    @endif
                                </span>
                            </div>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jatuh Tempo:</span>
                                    <span class="font-medium">{{ $payment->due_date->format('d/m/Y') }}</span>
                                </div>
                                @if ($payment->payment_date)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tgl Bayar:</span>
                                    <span class="font-medium">{{ $payment->payment_date->format('d/m/Y') }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jumlah:</span>
                                    <span class="font-medium">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                                @if ($payment->payment_method)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Metode:</span>
                                    <span class="font-medium">{{ ucfirst($payment->payment_method) }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Add this for status display -->
                            @if($payment->status === 'rejected')
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <div class="text-sm text-red-600 mb-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>Ditolak: {{ $payment->notes }}
                                    </div>
                                    <a href="{{ route('loan-payments.resubmit', $payment->id) }}"
                                       class="block w-full text-center px-3 py-2 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600 transition duration-200">
                                        Ajukan Ulang
                                    </a>
                                </div>
                            @elseif($payment->status === 'pending' && !$payment->payment_date)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <a href="{{ route('loan-payments.create', $loan->id) }}"
                                       class="block w-full text-center px-3 py-2 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600 transition duration-200">
                                        Bayar Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    @endif
</div>

<style>
    .container {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bg-gradient-to-r {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
</style>
@endsection
