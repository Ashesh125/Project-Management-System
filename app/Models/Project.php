<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'description'
    ];

    public function users(){
        return $this->hasManyThrough(User::class,Tasks::class,'user_id','id','id','project_id');
    }

    public function issue(){
        return $this->hasMany(Issue::class,'project_id','id');
    }

    public function lead(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function activities(){
        return $this->hasMany(Activity::class,'project_id','id');
    }

    public function getAvgActivitiesAttribute()
    {
        $activity = $this->activities;

        return round($activity->avg('status'));
    }
}
