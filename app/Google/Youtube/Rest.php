<?php

declare(strict_types=1);

namespace App\Google\Youtube;

class Rest
{
    private $service;

    public function __construct($client)
    {
        $this->service = new \Google_Service_YouTube($client);
    }

    # Method returns service
    public function get()
    {
        return $this->service;
    }

    # Method returns channel of logged in user
    public function getMyChannel()
    {
        $channels = $this->service->channels->listChannels('snippet,id,contentDetails', [
            "mine" => true,
        ]);

        return $channels[0];
    }

    # Method returns subscriptions of logged in user
    public function listSubscriptions($pageToken = null)
    {
        return $this->service->subscriptions->listSubscriptions('snippet', [
            "mine" => true,
            "maxResults" => 50,
            "pageToken" => $pageToken,
        ]);
    }
    # Form local class Channel to YouTube class Channel
    public function getChannels(array $channels)
    {
        $ids = [];

        foreach ($channels as $channel) {
            $ids[] = $channel->getChannelId();
        }

        if (empty($ids)) {
            return [];
        } 
            
        return $this->service->channels->listChannels('id,snippet,contentDetails', [
            'id' => $ids,
        ]);
    }

    # Method returns videos form channels
    public function getChannelVideos(string $channelId)
    {
        return $this->service->search->listSearch('snippet', [
            'channelId' => $channelId,
            'maxResults' => 50,
            'order' => 'date',
            'type' => "video",
        ]);
    }
}