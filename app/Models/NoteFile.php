<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteFile extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'note_files';
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
