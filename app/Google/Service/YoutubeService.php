<?php

declare(strict_types=1);

namespace App\Google\Service;

use App\Models\Youtube\Channel;

class YoutubeService
{
    public static $api = null;

    # Zwraca listę kanałow subskrybentów
    # Zapisuje je do bazy danych
    public static function getSubscriberChannels()
    {
        if (null == self::$api) {
            return [];
        }

        if (!Channel::where('user_id', auth()->id())->exists()) {
            $items = [];
            $subscriptions = self::$api->listSubscriptions();
      
            while ($subscriptions->nextPageToken != null) {
               $items = array_merge($items, $subscriptions->items);
               $pageToken = $subscriptions->nextPageToken;
               $subscriptions = self::$api->listSubscriptions($pageToken);
            }
      
            $result = array_merge($items, $subscriptions->items);
    
            foreach ($result as $item) {
                Channel::create([
                    'name' => $item->snippet->title,
                    'thumb' => $item->snippet->thumbnails->default->url,
                    'description' => $item->snippet->description,
                    'channelId' => $item->snippet->resourceId->channelId,
                    'user_id' => auth()->id()
                ]);
            }
        }

        return Channel::where('user_id', auth()->id())->get();
    }

    # Method returns videos form channels
    public static function getVideos(array $channels)
    {
        $videos = [];

        foreach ($channels as $channel) {
            $result = self::$api->getChannelVideos($channel);
            $videos = array_merge($videos, $result->items);
        }

        return $videos;
    }
}