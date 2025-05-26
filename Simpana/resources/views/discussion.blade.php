@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-2xl font-bold mb-2 text-primary flex items-center gap-2">
            <i class="fa-solid fa-comments"></i> Forum Diskusi Koperasi
        </h1>
        <p class="text-gray-600 mb-4">Berdiskusi seputar koperasi, tanya jawab, dan berbagi pengalaman bersama anggota lain.</p>
        <form class="mb-6" method="POST" action="{{ route('discussion.store') }}">
            @csrf
            <div class="flex flex-col md:flex-row gap-4">
                <input type="text" name="title" class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:outline-primary" placeholder="Judul diskusi baru..." required>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-secondary transition">Buat Diskusi</button>
            </div>
            <textarea name="body" class="w-full mt-3 border border-gray-300 rounded-md px-4 py-2 focus:outline-primary" rows="2" placeholder="Tulis pertanyaan atau topik diskusi..." required></textarea>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    @forelse($discussions as $discussion)
        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <h2 class="font-bold text-lg">{{ $discussion->title }}</h2>
            <p class="text-gray-700">{{ $discussion->body }}</p>
            <div class="text-xs text-gray-500 mt-2">Oleh: {{ $discussion->user->name ?? '-' }} | {{ $discussion->created_at->diffForHumans() }}</div>
            @if(Auth::id() == $discussion->user_id)
                <div class="mt-2">
                    <a href="{{ route('discussion.edit', $discussion) }}" class="text-blue-600 mr-2">Edit</a>
                    <form action="{{ route('discussion.destroy', $discussion) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600" onclick="return confirm('Yakin hapus diskusi?')">Hapus</button>
                    </form>
                </div>
            @endif
            @if($discussion->comments->count())
                <div class="mt-4 pl-4 border-l-2 border-primary">
                    @foreach($discussion->comments as $comment)
                        <div class="mb-2">
                            <span class="font-semibold">{{ $comment->user->name ?? '-' }}</span>:
                            <span>{{ $comment->comment }}</span>
                            <span class="text-xs text-gray-400">({{ $comment->created_at->diffForHumans() }})</span>
                        </div>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('discussion.comment.store', $discussion) }}" method="POST" class="mt-2">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="comment" class="flex-1 border rounded px-2 py-1" placeholder="Tulis balasan..." required>
                    <button type="submit" class="bg-primary text-white px-3 py-1 rounded">Balas</button>
                </div>
            </form>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-8 flex flex-col items-center justify-center">
            <i class="fa-solid fa-comments text-4xl text-gray-300 mb-4"></i>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Belum ada diskusi</h2>
            <p class="text-gray-500">Jadilah yang pertama memulai diskusi di forum ini!</p>
        </div>
    @endforelse
</div>
@endsection 