<?php

namespace App\Google\Youtube\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'youtube_videos';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'videoId',
        'channelId',
        'channelTitle',
        'thumb',
        'publishedAt',
    ];
}
