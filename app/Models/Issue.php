<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'activity_id',
        'user_id'
    ];

    public function activity(){
        return $this->belongsTo(Activity::class,'activity_id','id');
    }

}
