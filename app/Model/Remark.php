<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = [
        'body', 'user_id'
    ];


    /**
     *  Relations
     * 
     */

    public function remarkable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     *  Scope Function
     * 
     */

    public function scopeType($query, $type)
    {
        if ($type == "All") {
            return $query->where('remarkable_type','!=',null);
        } else {
            return $query->where('remarkable_type', $type);
        }
    }


    public function scopeAdmin($query, $id)
    {
        if ($id == 1) {
            return $query;
        } else {
            return $query->where('user_id','!=',1);
        }
    }
}
