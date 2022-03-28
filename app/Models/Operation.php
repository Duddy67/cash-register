<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    /**
     * Delete the model from the database (override).
     *
     * @return bool|null
     *
     * @throws \LogicException
     */
    public function delete()
    {
        $this->notes->delete();
        $this->coins->delete();
        $this->cents->delete();

        parent::delete();
    }

    public function getDailyTotal()
    {
        return Operation::getTotalOperations($this->entry_date);
    }

    /**
     * Compute the total operations or the daily total 
     * operations if the $entryDate parameter is provided.
     *
     * @return integer 
     */
    public static function getTotalOperations($entryDate = null)
    {
        $query = DB::table('operations')->select('type', 'total');

        if ($entryDate !== null) {
            $query->where('entry_date', $entryDate);
        }

        $operations = $query->get();

        $total = 0;

        foreach ($operations as $operation) {
            if ($operation->type == 'cash_deposit') {
                $total += $operation->total;
            }
            else {
                $total -= $operation->total;
            }
        }

        return $total;
    }
}
