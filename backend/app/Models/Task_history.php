<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task_history extends Model
{
    use HasFactory;
    protected $table = 'task_history';
    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'changed_by',
        'change_type',
        'old_value',
        'new_value',
        'changed_at',
    ];

    // Thêm các trường ảo vào mảng attributes của model
    protected $appends = ['old_value_names', 'new_value_names'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getOldValueNamesAttribute()
    {
        if ($this->change_type !== 'Người được phân công') {
            return $this->old_value;
        }

        $userIds = json_decode($this->old_value);
        if (is_array($userIds) && count($userIds) > 0) {
            return User::whereIn('id', $userIds)->value('username');
        }

        return "Không";
    }

    public function getNewValueNamesAttribute()
    {
        if ($this->change_type !== 'Người được phân công') {
            return $this->new_value;
        }
        $userIds = json_decode($this->new_value);
        if (is_array($userIds) && count($userIds) > 0) {
            return User::whereIn('id', $userIds)->value('username');
        }

        return "Không";
    }
}
