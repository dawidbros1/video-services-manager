<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Youtube [{{ $channel->name }}] Filmy
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 pb-4">
        <x-groups.header
            name="{{ $channel->name }}"
            description="{{ $channel->description }}"
            thumb="{{ $channel['thumb'] }}"
        />

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($videos as $video)
                <x-youtube.video :details="$video"/>
            @endforeach
        </div>
    </div>
</x-app-layout>
