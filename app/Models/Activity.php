<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'activities';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'project_id',
        'user_id',
        'description'
    ];

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'activity_id', 'id');
    }

    public function getAvgTaskAttribute()
    {
        $task = $this->tasks;

        return round($task->where('status','!=',2)->avg('status') * 100);
    }


    public function issues(){
        return $this->hasMany(Issue::class,'activity_id','id');
    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }


    public function supervisor(){
        return $this->hasOne(User::class,'id','user_id')->withTrashed();
    }
}
