@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Verifikasi Pembayaran Pinjaman</h1>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        @if (!isset($pendingPayments) || $pendingPayments->isEmpty())
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-gray-600 text-lg">Tidak ada pembayaran yang perlu diverifikasi.</p>
            <p class="text-gray-500 mt-2">Pembayaran akan muncul di sini ketika anggota melakukan pembayaran via transfer.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pinjaman</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Angsuran Ke</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Bayar</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingPayments as $payment)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $payment->id }}</td>
                        <td class="px-4 py-3">{{ $payment->loanApplication->user->name }}</td>
                        <td class="px-4 py-3">{{ $payment->loan_application_id }}</td>
                        <td class="px-4 py-3">{{ $payment->installment_number }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3">{{ $payment->payment_method ? ucfirst($payment->payment_method) : '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if ($payment->status == 'paid' || $payment->status == 'verified') bg-green-100 text-green-800
                                @elseif ($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                @if ($payment->payment_method == 'transfer' && $payment->payment_proof)
                                <a href="{{ Storage::url($payment->payment_proof) }}" 
                                   target="_blank" 
                                   class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                    Lihat Bukti
                                </a>
                                @endif
                                
                                <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                                        Verifikasi
                                    </button>
                                </form>
                                
                                <button onclick="showRejectForm({{ $payment->id }})" 
                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($pendingPayments->hasPages())
        <div class="mt-6">
            {{ $pendingPayments->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Modal for Rejection Reason -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <textarea id="rejection_reason" name="rejection_reason" rows="3" 
                          class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="hideRejectForm()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showRejectForm(paymentId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        
        form.action = `/admin/payments/${paymentId}/reject`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function hideRejectForm() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
@endsection