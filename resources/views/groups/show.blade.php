<x-app-layout>
    <x-slot name="header">
        <div class="flex" style="position: relative; width: 100%;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Grupa: ') }} {{ $group->name }}
            </h2>
    
            <div 
                id = "group-manage"
                class="flex p-1 cursor-pointer" 
                style = "position: absolute; right: 0px; border: 1px solid black;"
                data-manage="{{ route('group-manage', ['id' => $group->id]) }}"
            >
               <img class="icon" src = {{ asset('images/settings.png') }} />
               <span class="ml-1" style="line-height: 20px;">Zarządzaj grupą</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 pb-4">
        <x-groups.header
            name="{{ $group->name }}"
            description="TODO OPIS"
            thumb="{{ $group->getThumb() }}"
        />

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($videos as $video)
                <x-youtube.video :details="$video"/>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#group-manage').on('click', function() {
                window.location = $(this).data('manage');
            });
        });
    </script>
</x-app-layout>