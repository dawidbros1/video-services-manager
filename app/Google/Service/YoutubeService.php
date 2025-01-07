<?php

declare(strict_types=1);

namespace App\Google\Service;

use App\Google\Youtube\Models\Channel as YoutubeChannel;
use App\Google\Youtube\Models\Video as YoutubeVideo;
use Carbon\Carbon;

class YoutubeService
{
    public static $api = null;

    # Zwraca listę kanałow subskrybentów
    # Zapisuje je do bazy danych
    public static function getSubscriberChannels($channelId)
    {
        if (null == self::$api) {
            return [];
        }

        $pageToken = null;

        $channels_ids = auth()->user()->getYoutubeData($channelId, 'channels');

        if (empty($channels_ids)) {
            do {
                $subscriptions = self::$api->listSubscriptions($pageToken);

                foreach ($subscriptions->items as $item) {
                    $channels_ids[] = $item->snippet->resourceId->channelId;

                    if (YoutubeChannel::where('channelId', $item->snippet->resourceId->channelId)->exists()) {
                        continue;
                    }

                    YoutubeChannel::create([
                        'name' => $item->snippet->title,
                        'thumb' => $item->snippet->thumbnails->default->url,
                        'description' => $item->snippet->description,
                        'channelId' => $item->snippet->resourceId->channelId,
                    ]);
                }

                $pageToken = $subscriptions->nextPageToken;
            } while ($pageToken != null);

            auth()->user()->setYoutubeData($channelId, $channels_ids, 'channels');
        }

        return YoutubeChannel::whereIn('channelId', $channels_ids)->get();
    }

    public static function getVideos($channels)
    {
        // Upewnij się, że $channels jest tablicą
        if (!is_array($channels)) {
            $channels = [$channels];
        }

        foreach ($channels as $channelId) {
            $channel = YoutubeChannel::where('channelId', $channelId)->first();

            if ($channel && isset($channel->refresh_at)) {
                // Sprawdź, czy minęło 15 minut od ostatniego odświeżenia
                $refreshAt = Carbon::parse($channel->refresh_at);
                $now = Carbon::now();

                if ($refreshAt->diffInMinutes($now) < 15) {
                    // Jeśli nie minęło 15 minut, przejdź do następnego kanału
                    continue;
                }
            }

            // Pobierz filmy z API dla danego kanału
            $videos = self::$api->getChannelVideos($channelId)->items;
            $videosToSave = [];

            foreach ($videos as $video) {
                // Sprawdź, czy film o danym videoId już istnieje w bazie
                if (YoutubeVideo::where('videoId', $video->id->videoId)->exists()) {
                    // Jeśli film istnieje, pomiń go
                    continue;
                }

                // Dodaj wideo do tablicy nowych filmów
                $videosToSave[] = [
                    'title' => $video->snippet->title,
                    'videoId' => $video->id->videoId,
                    'channelId' => $channelId,
                    'channelTitle' => $video->snippet->channelTitle,
                    'thumb' => $video->snippet->thumbnails->medium->url,
                    'publishedAt' => Carbon::parse($video->snippet->publishedAt)->format('Y-m-d H:i:s'),
                ];
            }

            $channel->update(['refresh_at' => Carbon::now()]);
        }

        // Zapisz wszystkie nowe filmy za jednym razem
        if (!empty($videosToSave)) {
            YoutubeVideo::insert($videosToSave);
        }

        // Zwróć filmy z podanych kanałów
        return YoutubeVideo::whereIn('channelId', $channels)->orderBy('publishedAt', 'desc')->get();
    }
}
