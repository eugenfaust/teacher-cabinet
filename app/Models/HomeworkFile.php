<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkFile extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'homework_files';
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
