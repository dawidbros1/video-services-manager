<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('YouTube') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 pb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($subscriptions as $channel)
                <x-youtube.channel :details="$channel">
                    <x-slot name="actions">
                        <a href="https://www.youtube.com/channel/{{ $channel->channelId }}" target="_blank"
                            class="inline-block px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition">
                            Otwórz kanał
                        </a>
                
                        <a href="{{ route('youtube.videos', ['channelId' => $channel->channelId]) }}" href="https://www.youtube.com/channel/{{ $channel->channelId }}" target="_blank"
                            class="inline-block px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600 transition">
                            Zobacz filmy
                        </a>
                    </x-slot>
                </x-youtube.channel>
            @endforeach
        </div>
    </div>
</x-app-layout>
