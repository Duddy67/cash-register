<a href="{{ route('operations.create') }}" class="btn btn-primary">Nouvelle opération</a>

@if (!count($operations)) 
    <div class="alert alert-info mt-5" role="alert">
        Aucune opération n'a été trouvée.
    </div>
@else
    @inject('util', 'App\Models\Operation')

    <div class="h2 mt-5">Total caisse: {{ $util::zeroPadding($totalOperations / 100) }} €</div>

    <h2 class="text-center mb-3">Operations</h2>
    <table id="item-list" class="table table-hover table-striped">
        <thead class="table-success">
            <th scope="col" style="width: 30%">
                Date
            </th>
            <th scope="col" style="width: 30%">
            type 
            </th>
            <th scope="col" style="width: 20%">
                Montant
            </th>
            <th scope="col" style="width: 20%">
                Actions
            </th>
        </thead>
        <tbody>
            @foreach ($operations as $i => $operation)
                @php 
                    $date = null;
                    $next = $i + 1;
                    $previous = $i - 1;

		    if (isset($operations[$previous]) && $operations[$previous]->entry_date == $operation->entry_date) {
			$date = '--';
		    }
                    else {
			$entryDate = substr($operation->entry_date, 0, 10);
			$date = explode('-', $entryDate);
			$date = $date[2].'/'.$date[1].'/'.$date[0];
		    }

                @endphp
                <tr>
                    <td>{{ $date }}</td>
                    <td>{{ $types[$operation->type] }}</td>
                    <td>{{ $util::zeroPadding($operation->amount / 100) }} €</td>
                    <td>
                        <a href="{{ route('operations.edit', $operation->id) }}" class="btn btn-success">Editer</a>
                        <a href="#" id="delete-operation-{{ $operation->id}}" class="btn btn-danger ml-3">Supprimer</a>
                    </td>
                </tr>

                @if ($next == count($operations) || $operations[$next]->entry_date != $operation->entry_date)
                    <tr>
                        <td colspan="4" class="h5 total-amount">
			    <b class="ml-5">Total: {{ $util::zeroPadding($operation->getDailyAmount() / 100) }} €</b>
			    <a href="#" id="delete-daily-operations-{{ $operation->id}}" data-entry-date="{{ $operation->entry_date }}" class="btn btn-danger ml-5">Supprimer</a>
			</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <form id="deleteOperation" action="{{ url('/') }}/operations/" method="post">
        @method('delete')
        @csrf
    </form>

    <form id="deleteDailyOperations" action="{{ route('operations.massDestroy') }}" method="post">
        @method('delete')
        @csrf
	<input type="hidden" name="entry_date" id="entry-date" value="" />
    </form>
@endif
