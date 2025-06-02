@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-2xl">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">{{ auth()->user()->nama }}</h2>
                        <p class="text-gray-600">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('dashboard.shu') }}" class="flex items-center space-x-2 p-2 rounded-lg bg-blue-50 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2z" />
                        </svg>
                        <span>View SHU</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold mb-6">Unduh SHU</h1>
                
                <div class="mb-6">
                    <label for="tahun" class="block text-base font-medium text-gray-700 mb-2">Pilih Tahun</label>
                    <select id="tahun" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="toggleDownloadButton(this.value)">
                        <option value="">-- Pilih Tahun --</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <button id="download-pdf-btn" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 disabled:opacity-50 transition" disabled>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDownloadButton(year) {
        var btn = document.getElementById('download-pdf-btn');
        if(year) {
            btn.onclick = function() { window.location.href = "{{ url('dashboard/shu/download-pdf') }}/" + year; };
            btn.removeAttribute('disabled');
        } else {
            btn.onclick = null;
            btn.setAttribute('disabled', 'disabled');
        }
    }
</script>
@endsection