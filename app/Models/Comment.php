<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Issue;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'issue_id',
        'user_id'
    ];

    public function issue(){
        return $this->belongsTo(Issue::class,'issue_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
