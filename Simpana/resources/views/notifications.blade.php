@extends('layouts.app')

@section('content')
<div class="flex bg-gray-100 min-h-screen">
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#8C1414]">
                Notifikasi
            </h2>
            @if(isset($notifications) && count($notifications))
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#8C1414] text-white px-4 py-2 rounded hover:bg-[#6f0f0f]">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow divide-y">
            @php
                $unreadNotifications = $notifications->whereNull('read_at');
            @endphp

            @if(isset($unreadNotifications) && count($unreadNotifications))
                @foreach($unreadNotifications as $notif)
                    <div class="flex p-4 hover:bg-gray-50">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $notif->title }}</div>
                            <div class="text-gray-700 text-sm mt-1">
                                {{ $notif->message }}
                            </div>
                            <div class="text-xs text-gray-400 mt-2">{{ $notif->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @if(!$notif->read_at)
                            <form action="{{ route('notifications.markAsRead', $notif->id) }}" method="POST" class="ml-4">
                                @csrf
                                <button type="submit" class="text-[#8C1414] hover:text-[#6f0f0f]">
                                    Tandai Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="p-4 text-gray-500">Belum ada notifikasi.</div>
            @endif
        </div>
    </main>
</div>
@endsection
