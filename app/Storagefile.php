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
     * Get the owner associated with the file.
     */
    public function getSizeFormattedAttribute()
    {
        $base = log($this->size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
    
        return round(pow(1024, $base - floor($base)), 2) .' '. $suffixes[floor($base)];
    }
    
    public function hasAccess($userID) 
    {
        if ($this->user_id !== $userID && FileShares::where('file_id', $this->id)->where('user_id', $userID)->get()->isEmpty()) {
            return false;
        }
        
        return true;
    }
    
    public function isOwner($userID = null)
    {
        if ($this->user_id === $userID) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get the owner associated with the file.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    /**
     * Get the owner associated with the file.
     */
    public function sharedWith()
    {
        return $this->belongsToMany('App\User', 'file_shares', 'file_id', 'user_id');
    }
}
