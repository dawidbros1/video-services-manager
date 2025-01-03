<?php

namespace App\Models\Youtube;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'youtube_channels';

    protected $fillable = [
        'user_id',
        'name',
        'thumb',
        'description',
        'channelId',
    ];
}
