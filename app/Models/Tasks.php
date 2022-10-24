<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Tasks extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'due_date',
        'status',
        'description',
        'type',
        'project_id',
        'assigned_to'
    ];

    public function user()
    {
       return $this->hasOne(User::class,'id','assigned_to'); 
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
