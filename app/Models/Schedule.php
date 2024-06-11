<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'schedules';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
