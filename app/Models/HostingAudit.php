<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostingAudit extends Model
{
    protected $table = 'hosting_audits';

    protected $fillable = [
        'user_id',
        'action',
        'target',
        'payload',
        'result',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
