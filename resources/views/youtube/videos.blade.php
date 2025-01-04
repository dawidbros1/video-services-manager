<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('YouTube Videos') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        {{-- Informacje o kanale --}}
        <div class="bg-white shadow-md rounded p-4 mb-4">
            <div class="flex items-center">
                <img src="{{ $channel['thumb'] }}" alt="{{ $channel->anme }}" class="w-20 h-20 rounded-full mr-4">
                <div>
                    <h2 class="text-2xl font-bold">{{ $channel->name }}</h2>
                    <p class="text-gray-600">{{ $channel->description }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($videos as $video)
                <div class="card shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <a href="<?= 'https://www.youtube.com/watch?v=' . $video->id->videoId ?>" target="_blank">
                        <img src="<?= $video->snippet->thumbnails->medium->url ?>" class="w-full object-cover"
                            alt="<?= $video->snippet->title ?>">
                    </a>
                    <div class="p-3">
                        <h6 class="text-sm font-semibold truncate" title="<?= $video->snippet->title ?>">
                            <a href="<?= 'https://www.youtube.com/watch?v=' . $video->id->videoId ?>"
                                target="_blank" class="text-decoration-none text-gray-900 hover:text-blue-600">
                                <?= $video->snippet->title ?>
                            </a>
                        </h6>
                        <p class="text-xs text-gray-500">
                            <?= $video->snippet->channelTitle ?>
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ \App\Helper\Data::time_elapsed_string($video->snippet->publishedAt) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
                
    </div>
</x-app-layout>
