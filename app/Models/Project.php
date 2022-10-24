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
        'description'
    ];

    public function taskList()
    {
        return $this->hasMany(Tasks::class, 'project_id', 'id');
    }

    public function getAvgTaskAttribute()
    {
        $tasks = $this->taskList;
        
        return round($tasks->avg('status') * 100);
    }

    // public function users(){
    //     return $this->hasMany(User::class);
    // }
}
