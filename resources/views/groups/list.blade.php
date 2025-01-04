<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grupy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="position:relative">
                <div style="position:absolute; right: 5px; top: 5px;">
                    <x-secondary-button class="open_group_form" data-mode="create" data-route="{{ route('groups.create') }}">
                        DODAJ GRUPĘ
                    </x-secondary-button>
                </div>

                <div class="mt-2">
                    <div class="flex flex-wrap">
                        @foreach ($groups as $group)
                            <div class="w-1/3 p-2 group" data-id="{{ $group->id }}" data-name="{{ $group->name }}" data-thumb="{{ $group->thumb }}">
                                <div class="flex p-2" style="border: 1px solid black">
                                    <img class="pr-2 h-8" src="{{ $group->thumb }}" />
                                    <p class="mt-1" style="width: 75%">{{ $group->name }}</p>

                                    <div class="mr-2 flex mt-1 p-1" style="border: 1px solid black;">
                                        <img class="icon mr-1 pr-1 open_group_form" 
                                            data-mode="update"
                                            data-route="{{ route('groups.update') }}"
                                            style="border-right: 1px solid black;" 
                                            src="{{ asset('images/edit.png') }}"
                                            title="Edytuj"
                                        >

                                        <form action="{{ route('groups.delete') }}" method="POST"
                                            onsubmit="return confirm('Czy na pewno chcesz usunąć tę grupę?')">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="id" value="{{ $group->id }}">

                                            <img class="icon delete_group" src="{{ asset('images/delete.png') }}" title="Usuń">

                                            <button type="submit" style="display: none"></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id = "popup" style="display: none;">
        <!-- Tło z rozmyciem -->
        <div id="backdrop"
            style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); z-index: 10;">
        </div>

        <!-- Formularz -->
        <div id="popup-content"
            style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; border: 2px solid black; border-radius: 8px; padding: 20px; width: 400px; z-index: 20;">
            <h2 id="popup_title" style="text-align: center; margin-bottom: 20px; font-size: 24px"></h2>

            <form id = "popup-form" action="" method="POST">
                @csrf <!-- Token CSRF -->

                <input type = "hidden" name = "id" value = "" />

                <div style="margin-bottom: 15px;">
                    <label for="group-name" style="display: block;">Nazwa grupy:</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="group-name" 
                        placeholder="Wpisz nazwę grupy"
                        style="width: 100%; padding: 8px; border: 1px solid gray; border-radius: 4px;"
                    />
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="group-thumb" style="display: block;">Miniaturka grupy:</label>
                    <input 
                        type="text" 
                        name="thumb" 
                        id="group-thumb" 
                        placeholder="URL miniaturki"
                        style="width: 100%; padding: 8px; border: 1px solid gray; border-radius: 4px;"
                    />
                </div>

                <div style="text-align: center;">
                    <button style="padding: 10px 20px; background: #4caf50; color: white; border: none; border-radius: 4px; cursor: pointer;" 
                        type="submit"
                        >
                        Zatwierdź
                    </button>

                    <button style="padding: 10px 20px; background: gray; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;"
                        type="button" 
                        id="close-popup"
                        >
                        Zamknij
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const popup = $('#popup');
            const form = $('#popup-form')

            $('#close-popup').on('click', function() {
                $(popup).hide();
            });

            // otwarcie formularza CREATE | UPDATE
            $('.open_group_form').on('click', function() {
                const group = $(this).parents('.group');

                $(popup).show();
                $(form).attr('action', $(this).data('route'));
                $(popup).find('#popup_title').text('update' == $(this).data('mode') ? "Edycja grupy" : "Tworzenie grupy");

                ['id', 'name', 'thumb'].forEach(name => {
                    $(form).find('input[name="' + name + '"]').val($(group).data(name));
                });
            
            })

            $('.delete_group').on('click', function() {
                $(this).parent('form').find('button').click();
            });
        });
    </script>
</x-app-layout>
