<div class="card shadow-sm border border-gray-200 rounded-lg overflow-hidden">
    <a href="<?= 'https://www.youtube.com/watch?v=' . $details->videoId ?>" target="_blank">
        <img src="<?= $details->thumb ?>" class="w-full object-cover"
            alt="<?= $details->title ?>">
    </a>
    <div class="p-3">
        <h6 class="text-sm font-semibold truncate" title="<?= $details->title ?>">
            <a href="<?= 'https://www.youtube.com/watch?v=' . $details->videoId ?>"
                target="_blank" class="text-decoration-none text-gray-900 hover:text-blue-600">
                <?= $details->title ?>
            </a>
        </h6>
        <p class="text-xs text-gray-500">
            <?= $details->channelTitle ?>
        </p>
        <p class="text-xs text-gray-400">
            {{ \App\Helper\Data::time_elapsed_string($details->publishedAt) }}
        </p>
    </div>
</div>