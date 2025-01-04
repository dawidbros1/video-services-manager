<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('YouTube') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 pb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($subscriptions as $channel)
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <div class="flex items-center space-x-4">
                        <!-- Miniaturka kanału -->
                        <img src="{{ $channel->thumb }}" alt="Miniaturka {{ $channel->name }}"
                            class="w-16 h-16 rounded-full border">

                        <!-- Nazwa i ID kanału -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $channel->name }}</h3>
                            <p class="text-sm text-gray-500">ID: {{ $channel->channelId }}</p>
                        </div>
                    </div>

                    <!-- Opis kanału -->
                    <p class="mt-4 text-gray-700 text-sm line-clamp-3">
                        {{ $channel->description }}
                    </p>

                    <!-- Akcje -->
                    <div class="mt-4">
                        <a href="https://www.youtube.com/channel/{{ $channel->channelId }}" target="_blank"
                            class="inline-block px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition">
                            Otwórz kanał
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
