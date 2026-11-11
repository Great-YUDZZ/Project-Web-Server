<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingCronJob extends Model
{
    protected $table = 'hosting_cron_jobs';

    protected $fillable = [
        'name',
        'schedule',
        'command',
        'description',
        'last_run_at',
        'last_status',
        'last_output',
    ];

    protected function casts(): array
    {
        return [
            'last_run_at' => 'datetime',
        ];
    }
}
