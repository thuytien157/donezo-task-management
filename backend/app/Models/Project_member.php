<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Project_member extends Model
{
    use HasFactory;
    protected $table = 'project_members';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'user_id',
        'role',
        'joined_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
