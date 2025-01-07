<div class="bg-white shadow-lg rounded-lg p-4">
    <div class="flex items-center space-x-4">
        <!-- Miniaturka kanału -->
        <img src="{{ $details->thumb }}" alt="Miniaturka {{ $details->name }}"
            class="w-16 h-16 rounded-full border">

        <!-- Nazwa kanału -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800">{{ $details->name }}</h3>
        </div>
    </div>

    <!-- Opis kanału -->
    <p class="mt-4 text-gray-700 text-sm line-clamp-3">
        {{ $details->description }}
    </p>

    @isset($actions)
        <div class="mt-4">
            {{ $actions }}
        </div>
    @endisset
</div>