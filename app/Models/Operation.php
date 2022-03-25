<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Note;
use App\Models\Coin;
use App\Models\Cent;

class Operation extends Model
{
    use HasFactory;

    /**
     * Get the notes for the operation.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the coins for the operation.
     */
    public function coins()
    {
        return $this->hasMany(Coin::class);
    }

    /**
     * Get the cents for the operation.
     */
    public function cents()
    {
        return $this->hasMany(Cent::class);
    }
}
