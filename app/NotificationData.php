<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationData extends Model
{
    // use Notifiable;

    protected $table = 'notification_data';

    protected $fillable = [
        'user_id',
        'premium_ids',
    ];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
