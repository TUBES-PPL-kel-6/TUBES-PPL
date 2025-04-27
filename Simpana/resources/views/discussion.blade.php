@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-2xl font-bold mb-2 text-primary flex items-center gap-2">
            <i class="fa-solid fa-comments"></i> Forum Diskusi Koperasi
        </h1>
        <p class="text-gray-600 mb-4">Berdiskusi seputar koperasi, tanya jawab, dan berbagi pengalaman bersama anggota lain.</p>
        <form class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <input type="text" class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:outline-primary" placeholder="Judul diskusi baru...">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-secondary transition">Buat Diskusi</button>
            </div>
            <textarea class="w-full mt-3 border border-gray-300 rounded-md px-4 py-2 focus:outline-primary" rows="2" placeholder="Tulis pertanyaan atau topik diskusi..."></textarea>
        </form>
    </div>

    <!-- Pesan jika belum ada diskusi -->
    <div class="bg-white rounded-lg shadow p-8 flex flex-col items-center justify-center">
        <i class="fa-solid fa-comments text-4xl text-gray-300 mb-4"></i>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Belum ada diskusi</h2>
        <p class="text-gray-500">Jadilah yang pertama memulai diskusi di forum ini!</p>
    </div>
</div>
@endsection 