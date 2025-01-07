<?php

namespace App\Google\Youtube\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'youtube_channels';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'thumb',
        'description',
        'channelId',
        'refresh_at'
    ];
}
