<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'activity_logs';

    protected $fillable = [
        'user',
        'activity',
        'module',
        'ip_address',
        'created_at',
    ];

    public $timestamps = false;
}