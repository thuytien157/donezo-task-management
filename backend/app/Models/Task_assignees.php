<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_assignees extends Model
{
    use HasFactory;
    protected $table = 'task_assignees';
    public $timestamps = false;
    protected $fillable = [
        'task_id',
        'user_id',
        'assigned_at'
    ];
}
