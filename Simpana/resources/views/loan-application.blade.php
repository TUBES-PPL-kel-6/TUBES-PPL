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
                    <p class="text-xs text-gray-500 mb-3">Format yang diterima: PDF (Maksimal 2MB per file)</p>
                    <div class="flex items-center gap-4">
                        <input type="file" name="supporting_documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nominal Pinjaman -->
                    <div>
                        <label for="loan_amount" class="block text-sm font-medium text-gray-700 mb-1">Masukkan Nominal Pinjaman</label>
                        <input type="text" name="loan_amount" id="loan_amount" 
                               class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" 
                               placeholder="100.000" 
                               value="{{ old('loan_amount', '') }}"
                               oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                    </div>

                    <!-- Tenor -->
                    <div>
                        <label for="tenor" class="block text-sm font-medium text-gray-700 mb-1">Tenor</label>
                        <div class="relative">
                            <input type="number" name="tenor" id="tenor" min="1" max="100" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="1 - 12 bulan">
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
                    <!-- <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">Pilih metode pembayaran</option> -->
                            <!-- <option value="cash">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="debit">Kartu Debit</option> -->
                        <!-- </select> -->
                    <!-- </div> -->

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
    document.addEventListener('DOMContentLoaded', function() {
        // Get the loan amount input field
        const loanAmountInput = document.getElementById('loan_amount');
        
        // Format the input value initially if it has a value
        if (loanAmountInput.value) {
            loanAmountInput.value = formatRupiah(loanAmountInput.value);
        }
        
        // Add event listener for input changes with proper cursor position handling
        loanAmountInput.addEventListener('input', function(e) {
            const cursorPos = this.selectionStart;
            const oldLength = this.value.length;
            const oldValue = this.value;
            
            // Remove all non-digits for formatting
            const cleanValue = this.value.replace(/\D/g, '');
            
            // Format with thousand separators
            this.value = formatRupiah(cleanValue);
            
            // Adjust cursor position after formatting
            const newLength = this.value.length;
            const cursorAdjust = newLength - oldLength;
            
            if (cursorPos < oldLength) {
                this.setSelectionRange(cursorPos + cursorAdjust, cursorPos + cursorAdjust);
            }
        });
        
        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('application_date').value = today;
        document.getElementById('first_payment_date').value = today;
    });
    
    // Format number with thousand separators
    function formatRupiah(angka) {
        if (!angka || angka === '') return '';
        
        // Convert to string and add thousand separators
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Calculate total amount
    function calculateTotal() {
        const loanAmountInput = document.getElementById('loan_amount');
        let value = loanAmountInput.value.replace(/\D/g, '') || '0';
        const total = parseInt(value, 10);
        
        // If there's a total_amount element on the page, update it
        const totalAmountElement = document.getElementById('total_amount');
        if (totalAmountElement) {
            totalAmountElement.textContent = 'Rp' + total.toLocaleString('id-ID');
        }
    }
    
    // Validate file sizes before submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const fileInput = document.querySelector('input[type="file"]');
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        
        // Add submit event listener to the form
        form.addEventListener('submit', function(event) {
            if (fileInput.files.length > 0) {
                let isValid = true;
                let oversizedFiles = [];
                
                // Check each file size
                for (let i = 0; i < fileInput.files.length; i++) {
                    if (fileInput.files[i].size > maxSize) {
                        isValid = false;
                        oversizedFiles.push(fileInput.files[i].name);
                    }
                }
                
                // If any files exceed the limit, prevent submission and show error
                if (!isValid) {
                    event.preventDefault();
                    alert('File berikut melebihi batas ukuran 10MB: \n' + oversizedFiles.join('\n'));
                }
            }
        });
        
        // Initialize other features as before
        const loanAmountInput = document.getElementById('loan_amount');
        // Rest of your existing initialization code...
    });
    
    // Handle file selection with size validation
    function handleFileSelect(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        
        // Clear previous previews
        if (previewContainer) {
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
                
                // File size with warning if too large
                const fileSize = document.createElement('span');
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                
                if (file.size > maxSize) {
                    fileSize.className = 'text-xs text-red-500 ml-2 font-bold';
                    fileSize.textContent = `(${sizeMB} MB) - Ukuran melebihi batas!`;
                } else {
                    fileSize.className = 'text-xs text-gray-500 ml-2';
                    fileSize.textContent = `(${sizeMB} MB)`;
                }
                
                // Delete button
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'text-red-500 text-sm font-semibold hover:underline ml-4';
                deleteBtn.textContent = 'Hapus';
                deleteBtn.onclick = function() {
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
    }
    
    // Add file input change listener
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }
    
    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '{{ session('success') }}',
      confirmButtonColor: '#8C1414'
    });
    @endif
</script>
@endpush
@endsection
