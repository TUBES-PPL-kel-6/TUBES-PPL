@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Setoran Simpanan</h1>
            <a href="{{ route('admin.setoran.create') }}" 
               class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-800 transition">
                Tambah Setoran
            </a>
        </div>
    </div>

    <!-- Setoran List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Daftar Setoran</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Tanggal</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Nama Anggota</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Jenis</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Nominal</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Status</th>
                        <th class="py-3 px-4 text-left font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($setorans as $setoran)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $setoran->tanggal->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">{{ $setoran->user->nama }}</td>
                            <td class="py-3 px-4">{{ ucfirst($setoran->jenis_simpanan) }}</td>
                            <td class="py-3 px-4 text-green-600">
                                Rp{{ number_format($setoran->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    {{ $setoran->status === 'diterima' ? 'bg-green-100 text-green-800' : 
                                       ($setoran->status === 'ditolak' ? 'bg-red-100 text-red-800' : 
                                        'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($setoran->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.setoran.edit', $setoran->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.setoran.destroy', $setoran->id) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus setoran ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-4xl mb-2 opacity-30"></i>
                                    <p>Belum ada data setoran</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 