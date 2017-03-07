<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileShares extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_shares';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_id', 'user_id'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Get the users for who the file is shared.
     * 
     * return array
     */
    public static function usersFromFile($fileID) 
    {
        $shares = self::where('file_id', $fileID)->get();
        
        $users = array();
        
        foreach ($shares as $share) {
            $users[] = $share->user_id;
        }
        
        return $users;
    }
    
    /**
     * The user which belongs to the file share.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
