<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function groups(): HasMany {
        return $this->hasMany(Group::class, 'user_id');
    }

    public function getYoutubeData($channelId, $type = "channels")
    {
        $youtube_data = json_decode($this->youtube_data, true) ?? [];

        if (!array_key_exists($channelId, $youtube_data)) {
            $youtube_data[$channelId][$type] = [
                'items' => [],
                'refresh_at' => null,
            ];
        }

        $type_data = $youtube_data[$channelId][$type];

        if (null !== $type_data['refresh_at']) {
            $refreshAt = Carbon::parse($type_data['refresh_at']); 
            $now = Carbon::now();
        
            if ($refreshAt->diffInMinutes($now) >= 15) {
                return [];
            }
        }

        return $youtube_data[$channelId][$type]['items'] ?? [];
    }

    public function setYoutubeData($channelId, $data = null, $type = "channels")
    {
        $youtube_data = json_decode($this->youtube_data, true) ?? [];

        $youtube_data[$channelId][$type] = [
            'items' => $data,
            'refresh_at' => date('Y-m-d H:i:s')
        ];

        $this->youtube_data = json_encode($youtube_data);
        $this->save();
    }
}
