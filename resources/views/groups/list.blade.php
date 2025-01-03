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
                    <x-secondary-button id="create_group">
                        DODAJ GRUPĘ
                    </x-secondary-button>
                </div>

                <div class="mt-2">
                    <x-group.items :groups="$groups" />
                </div>
            </div>
        </div>
    </div>

    <x-group.form
        id="create_group"
        title="Tworzenie grupy"
        open="#create_group"
        route="groups.create"
    />
</x-app-layout>