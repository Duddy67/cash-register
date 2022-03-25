<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;

class Cent extends Model
{
    use HasFactory;

    /**
     * Get the operation that owns the cent.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
