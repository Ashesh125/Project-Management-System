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
        'priority',
        'activity_id',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed();
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

}
