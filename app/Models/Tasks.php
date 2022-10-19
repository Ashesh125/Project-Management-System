<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'project_id',
        'assigned_to'
    ];
}
