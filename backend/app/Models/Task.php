<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'created_by',
        'title',
        'description',
        'status',
        'deadline',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignees');
                    // ->withPivot('assigned_at');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function history(){
        return $this->hasMany(Task_history::class);
    }


}
