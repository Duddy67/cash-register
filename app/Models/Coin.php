<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;

class Coin extends Model
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
     * Get the operation that owns the coin.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
