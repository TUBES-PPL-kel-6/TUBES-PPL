@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#8C1414]">Sisa Hasil Usaha (SHU)</h1>
        
        <form action="{{ route('admin.shu.generate') }}" method="POST" class="flex gap-4">
            @csrf
            <select name="tahun" class="rounded-lg border-gray-300 focus:border-[#8C1414] focus:ring-[#8C1414]">
                @for($year = date('Y'); $year >= 2020; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <button type="submit" class="px-4 py-2 bg-[#8C1414] text-white rounded-lg hover:bg-[#641010] transition-colors">
                Generate SHU
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @forelse($shus as $tahun => $shuPerTahun)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">SHU Tahun {{ $tahun }}</h2>
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Anggota
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Simpanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Pinjaman
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kontribusi Simpanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kontribusi Pinjaman
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah SHU
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($shuPerTahun as $shu)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $shu->user->nama }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Rp {{ number_format($shu->total_simpanan, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Rp {{ number_format($shu->total_pinjaman, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Rp {{ number_format($shu->kontribusi_simpanan, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Rp {{ number_format($shu->kontribusi_pinjaman, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-[#8C1414]">
                                        Rp {{ number_format($shu->jumlah_shu, 0, ',', '.') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Summary Row -->
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                Total
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                Rp {{ number_format($shuPerTahun->sum('total_simpanan'), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                Rp {{ number_format($shuPerTahun->sum('total_pinjaman'), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                Rp {{ number_format($shuPerTahun->sum('kontribusi_simpanan'), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                Rp {{ number_format($shuPerTahun->sum('kontribusi_pinjaman'), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-[#8C1414]">
                                Rp {{ number_format($shuPerTahun->sum('jumlah_shu'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            Belum ada data SHU. Silakan generate SHU untuk tahun yang dipilih.
        </div>
    @endforelse
</div>
@endsection
