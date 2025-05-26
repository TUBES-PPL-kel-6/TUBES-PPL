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
                     <p class="font-medium">{{ Auth::user()->id }}</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                     <p class="font-medium">{{ Auth::user()->nama }}</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">NIK</label>
                     <p class="font-medium">{{ Auth::user()->nik }}</p>
                 </div>
             </div>
             <div>

                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                     <p class="font-medium">{{ Auth::user()->alamat }}</p>
                 </div>
                 <div class="mb-4">
                     <label class="block text-sm text-gray-600 mb-1">No. Telepon</label>
                     <p class="font-medium">{{ Auth::user()->no_telp }}</p>
                 </div>
             </div>
         </div>
     </div>

     <!-- Loan Application Form Section -->
     <div class="container mx-auto p-6">
         <!-- Loan Application Form Section -->
         <div class="bg-white rounded-lg shadow-lg p-8">
             <h2 class="text-2xl font-semibold text-gray-800 mb-6">Form Pengajuan Pinjaman</h2>
             <!-- Tambahkan di atas form -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
             <form method="POST" action="{{ route('loan.store') }}" enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                 <!-- Row 1 -->
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                     <!-- Pilih Produk Pinjaman -->
                     <div>
                         <label for="loan_product" class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk Pinjaman</label>
                         <select id="loan_product" name="loan_product" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                             <option value="">Pilih produk pinjaman</option>
                             <option value="pendidikan">Pendidikan</option>
                             <option value="usaha">Usaha</option>
                             <option value="konsumtif">Konsumtif</option>
                         </select>
                     </div>

                     <!-- Catatan Pengajuan -->
                     <div>
                         <label for="application_note" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengajuan</label>
                         <input type="text" id="application_note" name="application_note" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="Catatan pengajuan">
                     </div>
                 </div>

                 <!-- Upload Dokumen -->
                 <div class="mb-6">
                     <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Pendukung</label>
                     <p class="text-xs text-gray-500 mb-3">Format yang diterima: PDF, JPG, JPEG, PNG (Maksimal 2MB per file)</p>
                     <div class="flex items-center gap-4">
                         <input type="file" name="supporting_documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                     </div>
                 </div>

                 <!-- Row 2 -->
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                     <!-- Nominal Pinjaman -->
                     <div>
                         <label for="loan_amount" class="block text-sm font-medium text-gray-700 mb-1">Masukkan Nominal Pinjaman</label>
                         <input type="text" name="loan_amount" id="loan_amount" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="Rp10.000" value="{{ old('loan_amount', '') }}">
                     </div>

                     <!-- Tenor -->
                     <div>
                         <label for="tenor" class="block text-sm font-medium text-gray-700 mb-1">Tenor</label>
                         <div class="relative">
                             <input type="number" name="tenor" id="tenor" min="1" max="100" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="1 - 100">
                             <span class="absolute right-3 top-3 text-gray-500">Bulan</span>
                         </div>
                     </div>
                 </div>

                 <!-- Row 3 -->
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                     <!-- Tanggal Pengajuan -->
                     <div>
                         <label for="application_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                         <input type="date" name="application_date" id="application_date" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                     </div>

                     <!-- Tanggal Cicilan Pertama -->
                     <div>
                         <label for="first_payment_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Cicilan Pertama</label>
                         <input type="date" name="first_payment_date" id="first_payment_date" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                     </div>
                 </div>

                 <!-- Row 4 -->
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                     <!-- Metode Pembayaran -->
                     <div>
                         <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                         <select id="payment_method" name="payment_method" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                             <option value="">Pilih metode pembayaran</option>
                             <option value="cash">Tunai</option>
                             <option value="transfer">Transfer Bank</option>
                             <option value="debit">Kartu Debit</option>
                         </select>
                     </div>

                     <!-- Jaminan -->
                     <div>
                         <label for="collateral" class="block text-sm font-medium text-gray-700 mb-1">Jaminan</label>
                         <input type="text" name="collateral" id="collateral" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="Masukan keterangan jaminan jika ada">
                     </div>
                 </div>

                 <!-- Buttons -->
                 <div class="flex justify-end">
                     <button type="submit" class="px-6 py-3 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:outline-none">
                         Ajukan
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 @push('scripts')
 <script>
     function handleFileSelect(event) {
         const files = event.target.files;
         const previewContainer = document.getElementById('preview-container');

         // Clear previous previews
         previewContainer.innerHTML = '';

         for (let i = 0; i < files.length; i++) {
             const file = files[i];

             // Create a text-based preview
                 const preview = document.createElement('div');
                 preview.className = 'flex items-center justify-between w-full p-2 border rounded-md bg-gray-50 mb-2';

                 // File name
                     const fileName = document.createElement('span');
             fileName.className = 'text-sm text-gray-700 truncate';
             fileName.textContent = file.name;

             // File size
             const fileSize = document.createElement('span');
             fileSize.className = 'text-xs text-gray-500 ml-2';
             fileSize.textContent = `(${(file.size / 1024).toFixed(2)} KB)`;

             // Delete button
                 const deleteBtn = document.createElement('button');
                 deleteBtn.className = 'text-red-500 text-sm font-semibold hover:underline ml-4';
                 deleteBtn.textContent = 'Hapus';
                 deleteBtn.onclick = function () {
                     preview.remove();
                 };

// Append elements to the preview
                 preview.appendChild(fileName);
             preview.appendChild(fileSize);
                 preview.appendChild(deleteBtn);

             // Append the preview to the container
                 previewContainer.appendChild(preview);
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

     document.addEventListener('DOMContentLoaded', function () {
         const loanAmountInput = document.getElementById('loan_amount');

         loanAmountInput.addEventListener('input', function (e) {
             // Remove non-numeric characters
             let value = e.target.value.replace(/[^0-9]/g, '');

             // Format the value as currency
             if (value) {
                 value = parseInt(value).toLocaleString('id-ID', {
                     style: 'currency',
                     currency: 'IDR',
                     minimumFractionDigits: 0,
                 });
             }

             // Update the input value
             e.target.value = value.replace('Rp', 'Rp');
         });

         // Initialize with default value if present
         if (loanAmountInput.value) {
             const initialValue = loanAmountInput.value.replace(/[^0-9]/g, '');
             loanAmountInput.value = parseInt(initialValue).toLocaleString('id-ID', {
                 style: 'currency',
                 currency: 'IDR',
                 minimumFractionDigits: 0,
             }).replace('Rp', 'Rp');
         }
     });

     document.addEventListener('DOMContentLoaded', function () {
         const loanAmountInput = document.getElementById('loan_amount');

         loanAmountInput.addEventListener('input', function (e) {
             // Remove non-numeric characters
             let value = e.target.value.replace(/[^0-9]/g, '');

             // Format the value as currency (Rupiah)
             if (value) {
                 value = parseInt(value, 10).toLocaleString('id-ID');
             }

             // Update the input value with "Rp" prefix
             e.target.value = value ? `Rp${value}` : '';
         });

         // Format the input value on page load (if it has a value)
         if (loanAmountInput.value) {
             const initialValue = loanAmountInput.value.replace(/[^0-9]/g, '');
             loanAmountInput.value = initialValue ? `Rp${parseInt(initialValue, 10).toLocaleString('id-ID')}` : '';
         }
     });

     document.addEventListener('DOMContentLoaded', function () {
         const loanAmountInput = document.getElementById('loan_amount');

         // Format the input value on page load (if it has a value)
         if (loanAmountInput.value) {
             loanAmountInput.value = formatToRupiah(loanAmountInput.value.replace(/[^0-9]/g, ''));
         }

         // Add event listener to format the value as the user types
         loanAmountInput.addEventListener('input', function (e) {
             const rawValue = e.target.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
             e.target.value = formatToRupiah(rawValue); // Format and update the input value
         });

         // Helper function to format numbers as Rupiah
         function formatToRupiah(value) {
             if (!value) return ''; // Return empty if no value
             return `Rp${parseInt(value, 10).toLocaleString('id-ID')}`;
         }
     });
 </script>
@endpush
@endsection
