<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'action', 'subject_type', 'subject_id', 'user_id', 'before', 'after', 'ip'
    ];
}
