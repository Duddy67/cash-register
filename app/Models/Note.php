<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;

class Note extends Model
{
    use HasFactory;

    /**
     * Get the operation that owns the note.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
