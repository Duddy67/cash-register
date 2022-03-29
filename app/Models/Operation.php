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
        // First delete the relationships.
        $this->notes()->delete();
        $this->coins()->delete();
        $this->cents()->delete();

        parent::delete();
    }

    public function setCurrencyItems($notes, $coins, $cents)
    {
        foreach ($notes as $note) {
            $note = new Note($note);
            $this->notes()->save($note);
        }

        foreach ($coins as $coin) {
            $coin = new Coin($coin);
            $this->coins()->save($coin);
        }

        foreach ($cents as $cent) {
            $cent = new Cent($cent);
            $this->cents()->save($cent);
        }
    }

    public function getDailyAmount()
    {
        return Operation::getTotalOperations($this->entry_date);
    }

    /**
     * Compute the total operations or the daily amount
     * if the $entryDate parameter is set.
     *
     * @return signed integer 
     */
    public static function getTotalOperations($entryDate = null)
    {
        $query = DB::table('operations')->select('type', 'amount');

        // Get the daily amount of the operations.
        if ($entryDate !== null) {
            $query->where('entry_date', $entryDate);
        }

        $operations = $query->get();

        $total = 0;

        foreach ($operations as $operation) {
            if ($operation->type == 'cash_deposit') {
                $total += $operation->amount;
            }
            else {
                $total -= $operation->amount;
            }
        }

        return $total;
    }

    /* 
     * Possibly adds an extra zero after the first cent unit 
     * or a dot and 2 zeros after integer numbers.
     */
    public static function zeroPadding($number)
    {
        $number = strval($number);

        if (preg_match('#\.[0-9]{1}$#', $number)) {
            return $number.'0';
        }

        if (!preg_match('#\.#', $number)) {
            return $number.'.00';
        }

        return $number;
    }
}
