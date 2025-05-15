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
        @if ($pendingPayments->isEmpty())
        <div class="text-center py-6">
            <p class="text-gray-600">Tidak ada pembayaran yang perlu diverifikasi.</p>
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
                        <td class="px-4 py-3">{{ $payment->payment_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payment->payment_method) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600"
                                    onclick="viewPaymentDetail({{ $payment->id }})">
                                    Detail
                                </button>
                                <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                        Verifikasi
                                    </button>
                                </form>
                                <button class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600"
                                    onclick="rejectPayment({{ $payment->id }})">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pendingPayments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Pembayaran -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Detail Pembayaran</h3>
            <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div id="paymentDetails" class="mb-6">
            <!-- Payment details will be inserted here -->
        </div>
        <div class="mt-6 flex justify-end">
            <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded mr-2">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Reject Payment -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Tolak Pembayaran</h3>
            <button onclick="closeRejectModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <textarea id="rejection_reason" name="rejection_reason" rows="3" class="w-full p-2 border rounded"
                    required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded mr-2">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Konfirmasi Tolak</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function viewPaymentDetail(paymentId) {
        // In a real app, you would fetch details via AJAX
        fetch(`/admin/payments/${paymentId}`)
            .then(response => response.json())
            .then(data => {
                const details = document.getElementById('paymentDetails');
                let paymentProofHtml = '';
                
                if (data.payment_proof) {
                    paymentProofHtml = `
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Bukti Pembayaran</p>
                            <a href="${data.payment_proof}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                        </div>
                    `;
                }
                
                details.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">ID Pembayaran</p>
                            <p class="font-medium">${data.id}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Anggota</p>
                            <p class="font-medium">${data.user_name}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">ID Pinjaman</p>
                            <p class="font-medium">${data.loan_application_id}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Angsuran Ke</p>
                            <p class="font-medium">${data.installment_number}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jumlah</p>
                            <p class="font-medium">Rp ${Number(data.amount).toLocaleString('id-ID')}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Tanggal Bayar</p>
                            <p class="font-medium">${data.payment_date}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jatuh Tempo</p>
                            <p class="font-medium">${data.due_date}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Metode</p>
                            <p class="font-medium">${data.payment_method}</p>
                        </div>
                    </div>
                    ${paymentProofHtml}
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Catatan</p>
                        <p class="font-medium">${data.notes || '-'}</p>
                    </div>
                `;
                
                document.getElementById('detailModal').classList.remove('hidden');
                document.getElementById('detailModal').classList.add('flex');
            })
            .catch(error => {
                console.error('Error fetching payment details:', error);
                alert('Gagal mengambil detail pembayaran.');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }

    function rejectPayment(paymentId) {
        document.getElementById('rejectForm').action = `/admin/payments/${paymentId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
</script>
@endpush
@endsection