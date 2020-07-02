<?php

namespace App\Model;

use App\Http\Traits\RemarkCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes,RemarkCreator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'state'
    ];

    /**
     *  RelationShip
     * 
     */
    public function remarks(){
        return $this->morphMany('App\Model\Remark', 'remarkable');
    }
}
