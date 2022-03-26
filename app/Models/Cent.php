<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;

class Cent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numeral',
        'quantity'
    ];

    /**
     * Get the operation that owns the cent.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
