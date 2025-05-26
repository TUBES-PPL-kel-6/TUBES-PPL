@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh-120px)] bg-transparent">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8" style="box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);">
            <h2 class="text-2xl font-bold mb-6 text-center">Unduh SHU</h2>
            <div class="mb-6">
                <label for="tahun" class="block text-base font-medium text-gray-700 mb-2">Pilih Tahun</label>
                <select id="tahun" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" onchange="toggleDownloadButton(this.value)">
                    <option value="">-- Pilih Tahun --</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button id="download-pdf-btn" class="w-full bg-[#8C1414] text-white py-3 rounded-lg font-semibold text-lg hover:bg-[#641010] disabled:opacity-50 transition" disabled>Download PDF</button>
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