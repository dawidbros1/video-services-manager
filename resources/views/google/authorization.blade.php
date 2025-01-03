<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('YouTube') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div style="border: 1px solid black; width: 300px;" class="flex p-2 m-auto">
                    <img class="mr-2" src="{{ asset('images/google.png') }}">
                    <a style="line-height: 60px;" href = "<?=$google_login_url?>">Zaloguj się przez Google</a>
                </div>
            </div>
        </div>
    </div>

    <div>
        {{$value}}
    </div>
</x-app-layout>