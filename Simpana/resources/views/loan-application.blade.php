@extends('layouts.app')
 
 @section('content')
 <div class="container mx-auto p-4">
     <!-- Member Information Section -->
     <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
         <h2 class="text-xl font-semibold mb-4">Informasi Anggota</h2>
         <div class="grid grid-cols-2 gap-6">
             <div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Nomor Anggota</label>
                     <p class="font-medium">AG001</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                     <p class="font-medium">John Doe</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">NIK</label>
                     <p class="font-medium">3273082304990001</p>
                 </div>
             </div>
             <div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Tempat, Tanggal Lahir</label>
                     <p class="font-medium">Bandung, 23 April 1999</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                     <p class="font-medium">Jl. Sukabirus No. 123, Bandung</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">No. Telepon</label>
                     <p class="font-medium">081234567890</p>
                 </div>
             </div>
         </div>
     </div>
 
     <!-- Loan Application Form Section -->
     <div class="bg-white rounded-lg shadow-sm p-6">
         <h2 class="text-xl font-semibold mb-4">Form Pengajuan Pinjaman</h2>
         <form method="POST" action="{{ route('loan.store') }}" enctype="multipart/form-data">
             @csrf
 
             <!-- Row 1 -->
             <div class="grid grid-cols-2 gap-6 mb-4">
                 <!-- Pilih Produk Pinjaman -->
                 <div>
                     <label for="loan_product" class="block text-sm mb-1">Pilih produk pinjaman</label>
                     <select id="loan_product" name="loan_product" class="w-full p-2 border rounded-md">
                         <option value="">Pilih produk pinjaman</option>
                         <option value="pendidikan">Pendidikan</option>
                         <option value="usaha">Usaha</option>
                         <option value="konsumtif">Konsumtif</option>
                     </select>
                 </div>
 
                 <!-- Catatan Pengajuan -->
                 <div>
                     <label for="application_note" class="block text-sm mb-1">Catatan pengajuan</label>
                     <input type="text" id="application_note" name="application_note" class="w-full p-2 border rounded-md" placeholder="Catatan pengajuan">
                 </div>
             </div>
 
             <!-- Upload Dokumen -->
             <div class="mb-6">
                 <label class="block text-sm mb-2">Upload dokumen pendukung</label>
                 <div class="flex flex-wrap gap-4">
                     <!-- Upload Button -->
                     <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed relative cursor-pointer">
                         <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJmZWF0aGVyIGZlYXRoZXItcGx1cyI+PGxpbmUgeDE9IjEyIiB5MT0iNSIgeDI9IjEyIiB5Mj0iMTkiPjwvbGluZT48bGluZSB4MT0iNSIgeTE9IjEyIiB4Mj0iMTkiIHkyPSIxMiI+PC9saW5lPjwvc3ZnPg==" class="w-8 h-8 text-blue-500">
                         <input type="file" name="supporting_documents[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileSelect(event)">
                     </div>
                     <!-- Preview Container -->
                     <div id="preview-container" class="flex flex-wrap gap-4">
                         <!-- Previews will be added here -->
                     </div>
                 </div>
             </div>
 
             <!-- Row 2 -->
             <div class="grid grid-cols-2 gap-6 mb-4">
                 <!-- Nominal Pinjaman -->
                 <div>
                     <label for="loan_amount" class="block text-sm mb-1">Masukkan nominal pinjaman</label>
                     <input type="text" name="loan_amount" id="loan_amount" class="w-full p-2 border rounded-md" placeholder="500.000">
                 </div>
 
                 <!-- Tenor -->
                 <div>
                     <label for="tenor" class="block text-sm mb-1">Tenor</label>
                     <div class="relative">
                         <input type="text" name="tenor" id="tenor" class="w-full p-2 border rounded-md" placeholder="1 - 100">
                         <span class="absolute right-3 top-2 text-gray-500">Bulan</span>
                     </div>
                 </div>
             </div>
 
             <!-- Row 3 -->
             <div class="grid grid-cols-2 gap-6 mb-4">
                 <!-- Tanggal Pengajuan -->
                 <div>
                     <label for="application_date" class="block text-sm mb-1">Tanggal pengajuan</label>
                     <input type="date" name="application_date" id="application_date" class="w-full p-2 border rounded-md">
                 </div>
 
                 <!-- Tanggal Cicilan Pertama -->
                 <div>
                     <label for="first_payment_date" class="block text-sm mb-1">Tanggal cicilan pertama</label>
                     <input type="date" name="first_payment_date" id="first_payment_date" class="w-full p-2 border rounded-md">
                 </div>
             </div>
 
             <!-- Row 4 -->
             <div class="grid grid-cols-2 gap-6 mb-4">
                 <!-- Metode Pembayaran -->
                 <div>
                     <label for="payment_method" class="block text-sm mb-1">Metode Pembayaran</label>
                     <select id="payment_method" name="payment_method" class="w-full p-2 border rounded-md">
                         <option value="">Pilih metode pembayaran</option>
                         <option value="cash">Tunai</option>
                         <option value="transfer">Transfer Bank</option>
                         <option value="debit">Kartu Debit</option>
                     </select>
                 </div>
 
                 <!-- Jaminan -->
                 <div>
                     <label for="collateral" class="block text-sm mb-1">Jaminan</label>
                     <input type="text" name="collateral" id="collateral" class="w-full p-2 border rounded-md" placeholder="Masukan keterangan jaminan jika ada">
                 </div>
             </div>
 
             <!-- Total -->
             <div class="flex justify-end items-center mb-4">
                 <span class="text-sm mr-2">Total yang akan didapat</span>
                 <span class="font-semibold" id="total_amount">Rp0,00</span>
             </div>
 
             <!-- Buttons -->
             <div class="flex justify-end space-x-2">
                 <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                     Ajukan
                 </button>
             </div>
         </form>
     </div>
 
     <!-- Surat Persetujuan Pinjaman Section -->
     @if(isset($latestLoan) && in_array($latestLoan->status, ['approved', 'rejected']))
     <div class="bg-white rounded-xl shadow-lg p-6 mt-8 border border-gray-200">
         <h2 class="text-xl font-bold mb-5 text-gray-800 flex items-center gap-2">
             <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4" /></svg>
             Surat Persetujuan Pinjaman
         </h2>
         <div class="flex flex-wrap items-center gap-6 divide-x divide-gray-200">
             <div class="pr-6 flex items-center gap-2">
                 <span class="font-semibold text-gray-700">Status:</span>
                 @if($latestLoan->status == 'approved')
                     <span class="flex items-center gap-1 px-2 py-1 rounded bg-green-100 text-green-700 font-semibold">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                         Disetujui
                     </span>
                 @else
                     <span class="flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 font-semibold">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                         Ditolak
                     </span>
                 @endif
             </div>
             <div class="pl-6 pr-6 min-w-[170px]">
                 <span class="block text-gray-500 text-xs font-medium">Total Pinjaman</span>
                 <span class="font-bold text-gray-800">Rp {{ number_format($latestLoan->loan_amount, 0, ',', '.') }}</span>
             </div>
             <div class="pl-6 pr-6 min-w-[140px]">
                 <span class="block text-gray-500 text-xs font-medium">Durasi</span>
                 <span class="font-bold text-gray-800">{{ $latestLoan->tenor }} Bulan</span>
             </div>
             <div class="pl-6 pr-6 min-w-[170px]">
                 <span class="block text-gray-500 text-xs font-medium">Setoran/Bulan</span>
                 <span class="font-bold text-gray-800">Rp {{ number_format($latestLoan->loan_amount / max($latestLoan->tenor,1), 0, ',', '.') }}</span>
             </div>
             <div class="pl-6 pr-6 min-w-[180px]">
                 <span class="block text-gray-500 text-xs font-medium">Catatan Admin</span>
                 <span class="text-gray-700">{{ $latestLoan->application_note ?? '-' }}</span>
             </div>
             <div class="pl-6 flex items-center">
                 <a href="{{ route('loan.downloadApprovalLetter', $latestLoan->id) }}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition font-semibold">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                     Download Surat
                 </a>
             </div>
         </div>
     </div>
     @endif
 </div>
 
 @push('scripts')
 <script>
     function handleFileSelect(event) {
         const files = event.target.files;
         const previewContainer = document.getElementById('preview-container');
 
         for (let i = 0; i < files.length; i++) {
             const file = files[i];
             const reader = new FileReader();
             
             reader.onload = function(e) {
                 const preview = document.createElement('div');
                 preview.className = 'relative w-24 h-24 group';
                 
                 const content = document.createElement('div');
                 content.className = 'w-full h-full rounded-lg border-2 border-gray-200 overflow-hidden';
                 
                 if (file.type.startsWith('image/')) {
                     // If it's an image, show image preview
                     const img = document.createElement('img');
                     img.src = e.target.result;
                     img.className = 'w-full h-full object-cover';
                     content.appendChild(img);
                 } else {
                     // If it's not an image, show file icon and name
                     content.className += ' bg-gray-50 flex flex-col items-center justify-center p-2';
                     content.innerHTML = `
                         <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                         </svg>
                         <span class="text-xs mt-1 text-center truncate w-full">${file.name}</span>
                     `;
                 }
 
                 // Delete button
                 const deleteBtn = document.createElement('button');
                 deleteBtn.className = 'absolute top-0 right-0 hidden group-hover:flex bg-red-500 text-white rounded-full w-6 h-6 items-center justify-center -mt-2 -mr-2';
                 deleteBtn.innerHTML = '×';
                 deleteBtn.onclick = function() {
                     preview.remove();
                 };
 
                 preview.appendChild(content);
                 preview.appendChild(deleteBtn);
                 previewContainer.appendChild(preview);
             };
 
             if (file.type.startsWith('image/')) {
                 reader.readAsDataURL(file);
             } else {
                 reader.readAsText(file);
             }
         }
     }
 
     document.addEventListener('DOMContentLoaded', function() {
         // Calculate total amount
         function calculateTotal() {
             const loanAmount = parseFloat(document.getElementById('loan_amount').value.replace(/[^0-9]/g, '')) || 0;
             const total = loanAmount;
 
             document.getElementById('total_amount').textContent = 
                 'Rp' + total.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
         }
 
         // Add event listener to loan amount input
         document.getElementById('loan_amount').addEventListener('input', calculateTotal);
 
         // Set default dates
         const today = new Date().toISOString().split('T')[0];
         document.getElementById('application_date').value = today;
         document.getElementById('first_payment_date').value = today;
     });
 </script>
@endpush
@endsection