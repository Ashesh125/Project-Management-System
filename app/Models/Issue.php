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

    public function user(){
        return $this->hasOne(User::class,'id','user_id')->withTrashed();
    }

    public function comments(){
        return $this->hasMany(Comment::class,'issue_id','id');
    }
}
