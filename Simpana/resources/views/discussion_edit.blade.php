@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <form method="POST" action="{{ route('discussion.update', $discussion) }}">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $discussion->title }}" class="w-full border rounded mb-2 px-2 py-1" required>
        <textarea name="body" class="w-full border rounded mb-2 px-2 py-1" required>{{ $discussion->body }}</textarea>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('discussion.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection 