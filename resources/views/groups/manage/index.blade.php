<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zarządzanie grupą: ') }} {{ $group->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 pb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($channels as $channel)
                <x-youtube.channel :details="$channel">
                    <x-slot name="actions">
                        @if ($channel->group_channel_id) 
                            <form action = "{{ route('group-manage.remove')}}" method = "POST">
                                @csrf
                                @method('DELETE')

                                <input type = "hidden" name = "id" value="{{$channel->group_channel_id}}">
    
                                <button class="inline-block px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition" type = "submit">
                                    Usuń z grupy
                                </button>
                            </form>
                        @else
                            <form action = "{{ route('group-manage.insert')}}" method = "POST">
                                @csrf
                                <input type = "hidden" name = "youtube_channel_id" value="{{$channel->id}}">
                                <input type = "hidden" name = "group_id" value="{{$group->id}}">

                                <button class="inline-block px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded hover:bg-green-600 transition" type = "submit">
                                    Dodaj do grupy
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-youtube.channel>
            @endforeach
        </div>
    </div>
</x-app-layout>