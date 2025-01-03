<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Youtube\Channel;

class YouTubeService
{
    public static $api = null;

    public static function getSubscriptions()
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
}