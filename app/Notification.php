<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'user_id', 'file_id', 'file_name', 'sharer_id', 'sharer_name'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    
    const TYPE_NEW = 1;
    const TYPE_DELETE = 2;
    const TYPE_RESTORE = 3;
    const TYPE_SHARE = 4;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @return string
     */
    public function text()
    {
        if ($this->type === self::TYPE_NEW) {
            $text = '<b>You</b> uploaded the file <b>'.$this->file_name.'</b>';
        } elseif ($this->type === self::TYPE_DELETE) {
            $text = '<b>You</b> deleted the file <b>'.$this->file_name.'</b>';
        } elseif ($this->type === self::TYPE_RESTORE) {
            $text = '<b>You</b> restored the file <b>'.$this->file_name.'</b>';
        } elseif ($this->type === self::TYPE_SHARE) {
            $text = '<b>'.$this->sharer_name.'</b> shared the file <b>'.$this->file_name.'</b>';
        }
        
        return $text;
    }
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @return string
     */
    public function badge()
    {
        if ($this->type === self::TYPE_NEW) {
            $text = '<span class="badge">new</span>';
        } elseif ($this->type === self::TYPE_DELETE) {
            $text = '<span class="badge">delete</span>';
        } elseif ($this->type === self::TYPE_RESTORE) {
            $text = '<span class="badge">restore</span>';
        } elseif ($this->type === self::TYPE_SHARE) {
            $text = '<span class="badge">share</span>';
        }
        
        return $text;
    }
}
