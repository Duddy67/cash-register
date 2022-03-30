<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Note;
use App\Models\Coin;
use App\Models\Cent;
use Carbon\Carbon;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operations = Operation::orderBy('entry_date', 'desc')->get();
        $page = 'operations';
        $types = ['cash_deposit' => 'Dépôt de caisse', 'delivery_in_bank' => 'Retour en banque', 'withdrawal' => 'Retrait'];
        $totalOperations = Operation::getTotalOperations();
        return view('index', compact('operations', 'page', 'types', 'totalOperations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'operation';
        return view('index', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Ensure (again) the entry date field is filled out.
        $this->validate($request, [
            'entry_date' => 'required',
        ]);

        // Get the currency items.
        $notes = $this->parseCurrencyItem($request, 'note');
        $coins = $this->parseCurrencyItem($request, 'coin');
        $cents = $this->parseCurrencyItem($request, 'cent');
        // Get the amount of the operation (in cents).
        $amount = $this->getAmount($notes, $coins, $cents);

        if (empty($amount)) {
            return redirect()->route('operations.create')->with('error', 'Merci de renseigner au moins un des champs: Billets, Pièces ou Centimes.');
        }
        
        // Create a new operation.
        $operation = new Operation;
        $operation->type = $request->input('type');
        $operation->entry_date = Carbon::createFromFormat('!Y-m-d', $request->input('entry_date'));
        $operation->comment = $request->input('comment');
        $operation->amount = $amount;
        $operation->save();

        $operation->setCurrencyItems($notes, $coins, $cents);

        return redirect()->route('operations.edit', $operation->id)->with('success', 'Opération créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operation = Operation::findOrFail($id);
        $page = 'operation';
        // Convert in cents.
        $amount = $operation->amount / 100;
        $entryDate = substr($operation->entry_date, 0, 10);
        return view('index', compact('operation', 'page', 'id', 'amount', 'entryDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the currency items.
        $notes = $this->parseCurrencyItem($request, 'note');
        $coins = $this->parseCurrencyItem($request, 'coin');
        $cents = $this->parseCurrencyItem($request, 'cent');
        // Get the amount of the operation (in cents).
        $amount = $this->getAmount($notes, $coins, $cents);

        if (empty($amount)) {
            return redirect()->route('operations.create')->with('error', 'Merci de renseigner au moins un des champs: Billets, Pièces ou Centimes.');
        }

        // Update the operation.
        $operation = Operation::findOrFail($id);
        $operation->type = $request->input('type');
        $operation->entry_date = Carbon::createFromFormat('!Y-m-d', $request->input('entry_date'));
        $operation->comment = $request->input('comment');
        $operation->amount = $amount;
        $operation->save();

        // Reset the currency items.
        $operation->notes()->delete();
        $operation->coins()->delete();
        $operation->cents()->delete();

        $operation->setCurrencyItems($notes, $coins, $cents);

        return redirect()->route('operations.edit', $id)->with('success', 'Opération mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operation = Operation::findOrFail($id);
        $operation->delete();
        
        return redirect()->route('operations.index')->with('success', 'Opération supprimée avec succès.');
    }

    /**
     * Removes daily operations from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function massDestroy(Request $request)
    {
	Operation::where('entry_date', $request->input('entry_date'))->each(function ($operation, $key) {
            $operation->delete();
        });

        return redirect()->route('operations.index')->with('success', 'Opération du jour supprimée avec succès.');
    }

    private function parseCurrencyItem($request, $type)
    {
        $results = [];

        foreach ($request->all() as $key => $val) {
            if (preg_match('#^'.$type.'_numeral_([0-9]+)$#', $key, $matches)) {
                $idNb = $matches[1];
                // Ensure the integer value is valid.
                if (ctype_digit($request->input($type.'_quantity_'.$idNb)) && $request->input($type.'_quantity_'.$idNb) > 0) {
                    $results[] = ['numeral' => $val, 'quantity' => $request->input($type.'_quantity_'.$idNb)];
                }
            }
        }

        return $results;
    }

    private function getAmount($notes, $coins, $cents)
    {
        $amount = 0;

        foreach ($notes as $note) {
            $amount += $note['numeral'] * $note['quantity'];
        }

        foreach ($coins as $coin) {
            $amount += $coin['numeral'] * $coin['quantity'];
        }

        // Convert amount in cents.
        $amount = $amount * 100;

        // Append the cents
        foreach ($cents as $cent) {
            $amount += $cent['numeral'] * $cent['quantity'];
        }

        return $amount;
    }
}
