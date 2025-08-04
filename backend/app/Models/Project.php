<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    public $timestamps = true;
    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'is_group_project',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'is_group_project' => 'boolean',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_members')->withPivot('role');
    }
}
