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
                    $entryDate = substr($operation->entry_date, 0, 10);
                    $date = explode('-', $entryDate);
                    $next = $i + 1;
                @endphp
                <tr>
                    <td>{{ $date[2].'/'.$date[1].'/'.$date[0] }}</td>
                    <td>{{ $types[$operation->type] }}</td>
                    <td>{{ $util::zeroPadding($operation->amount / 100) }} €</td>
                    <td>
                        <a href="{{ route('operations.edit', $operation->id) }}" class="btn btn-success">Editer</a>
                        <a href="#" id="delete-operation-{{ $operation->id}}" class="btn btn-danger ml-3">Supprimer</a>
                    </td>
                </tr>

                @if ($next == count($operations) || $operations[$next]->entry_date != $operation->entry_date)
                    <tr>
                        <td colspan="4" class="h5 total-amount">Total: {{ $util::zeroPadding($operation->getDailyAmount() / 100) }} €</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <form id="deleteOperation" action="{{ url('/') }}/operations/" method="post">
        @method('delete')
        @csrf
    </form>
@endif
