<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Note;
use App\Models\Coin;
use App\Models\Cent;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operations = Operation::all();
        $page = 'operations';
        return view('index', compact('operations', 'page'));
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
        // Get the different currency parts.
        $notes = $this->parseCurrencyItem($request, 'note');
        $coins = $this->parseCurrencyItem($request, 'coin');
        $cents = $this->parseCurrencyItem($request, 'cent');
        // Get the total of the operation (in cents).
        $total = $this->getTotal($notes, $coins, $cents);

        // Create a new operation.
        $operation = new Operation;
        $operation->type = $request->input('type');
        $operation->comment = $request->input('comment');
        $operation->total = $total;
        $operation->save();

        foreach ($notes as $note) {
            $note = new Note($note);
            $operation->notes()->save($note);
        }

        foreach ($coins as $coin) {
            $coin = new Coin($coin);
            $operation->coins()->save($coin);
        }

        foreach ($cents as $cent) {
            $cent = new Cent($cent);
            $operation->cents()->save($cent);
        }

        return redirect()->route('operations.edit', $operation->id)->with('success', 'Operation successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operation = Operation::find($id);
        $page = 'operation';
        $total = $operation->total / 100;
        return view('index', compact('operation', 'page', 'id', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operation = Operation::find($id);
        $page = 'operation';
        // Convert in cents.
        $total = $operation->total / 100;
        return view('index', compact('operation', 'page', 'id', 'total'));
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
        // Get the different currency parts.
        $notes = $this->parseCurrencyItem($request, 'note');
        $coins = $this->parseCurrencyItem($request, 'coin');
        $cents = $this->parseCurrencyItem($request, 'cent');
        // Get the total of the operation (in cents).
        $total = $this->getTotal($notes, $coins, $cents);

        $operation = Operation::find($id);
        $operation->type = $request->input('type');
        $operation->comment = $request->input('comment');
        $operation->total = $total;
        $operation->save();

        $operation->notes()->delete();
        $operation->coins()->delete();
        $operation->cents()->delete();

        foreach ($notes as $note) {
            $note = new Note($note);
            $operation->notes()->save($note);
        }

        foreach ($coins as $coin) {
            $coin = new Coin($coin);
            $operation->coins()->save($coin);
        }

        foreach ($cents as $cent) {
            $cent = new Cent($cent);
            $operation->cents()->save($cent);
        }

        return redirect()->route('operations.edit', $id)->with('success', 'Operation successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    private function getTotal($notes, $coins, $cents)
    {
        $total = 0;

        foreach ($notes as $note) {
            $total += $note['numeral'] * $note['quantity'];
        }

        foreach ($coins as $coin) {
            $total += $coin['numeral'] * $coin['quantity'];
        }

        // Convert total in cents.
        $total = $total * 100;

        // Append the cents
        foreach ($cents as $cent) {
            $total += $cent['numeral'] * $cent['quantity'];
        }

        return $total;
    }
}
