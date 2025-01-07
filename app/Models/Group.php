<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'thumb',
        'user_id',
    ];

    public $group_channel_id = null;

    public function getThumb() {
        if (!empty($this->thumb)) {
            return $this->thumb;
        }

        return asset('images/image.png');
    }
}
