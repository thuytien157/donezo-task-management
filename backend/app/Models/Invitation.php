<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $table = 'invitations';
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'invited_by_user_id',
        'invited_email',
        'token',
        'status',
        'expires_at',
    ];
}
