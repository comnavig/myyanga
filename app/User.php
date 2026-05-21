<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar', 'mobile','whatsapp','status','type', 'notificationList'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function favourites()
    {
		return $this->hasMany('App\ProductFavourite');
	}
    
    public function orders()
    {
		return $this->hasMany('App\Order');
	}
    
    public function brands()
    {
		return $this->hasMany('App\Listing');
	}
	
    public function products()
    {
		return $this->hasMany('App\Product');
	}
    
    public function follows()
    {
		return $this->hasMany('App\ListingFollow');
	}
    
    public function pyls()
    {
		return $this->hasMany('App\UserPostYourLook');
	}
	
	public function notification()
	{
		return $this->hasOne('App\UserNotification');
	}
	public function notificationsData()
    {
        return $this->hasMany('App\NotificationData');
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) return null;
        if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($value);
    }
}
