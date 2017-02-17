<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'fullname', 'email', 'password', 'foldername'
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
     * Get the owner associated with the file.
     */
    public static function getAllforSelectbox()
    {
        $users = array();
        $usersAll = self::all()->except(\Auth::id());
        
        foreach ($usersAll as $user) {
            $users[$user->id] = $user->fullname;
        }
        
        return $users;
    }
    
    /**
     * Get the owner associated with the file.
     */
    public function photoURL()
    {
        if ($this->photo === null) {
            $photo =  asset('img/user_photo.png');
        } else {
            $photo =  asset('storage/userphotos/'.$this->photo);
        }
        
        return $photo;
    }
}
