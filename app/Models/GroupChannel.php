<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChannel extends Model
{
    protected $table = 'group_channels';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'group_id',
        'channelId',
        'youtube_channel_id'
    ];
}
