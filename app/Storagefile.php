<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storagefile extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'mime', 'original_filename', 'size', 'user_id'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    
    /**
     * Get the formatted file size.
     * 
     * @return string
     */
    public function getSizeFormattedAttribute()
    {
        $base = log($this->size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
    
        return round(pow(1024, $base - floor($base)), 2) .' '. $suffixes[floor($base)];
    }
    
    /**
     * Determine if the user has access to the file.
     * 
     * @return bool
     */
    public function hasAccess($userID) 
    {
        if ($this->user_id !== $userID && FileShares::where('file_id', $this->id)->where('user_id', $userID)->get()->isEmpty()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Determine if the user is the owner of the file.
     * 
     * @return bool
     */
    public function isOwner($userID = null)
    {
        if ($this->user_id === $userID) {
            return true;
        }
        
        return false;
    }
    
    /**
     * The user that owns the file.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    /**
     * The users that have access to the file.
     */
    public function sharedWith()
    {
        return $this->belongsToMany('App\User', 'file_shares', 'file_id', 'user_id');
    }
}
