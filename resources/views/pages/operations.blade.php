<a href="{{ route('operations.create') }}" class="btn btn-primary">Nouvelle opération</a>
<h2 class="text-center">Operations</h2>
<div>{{ $totalOperations / 100 }}</div>
<table id="item-list" class="table table-hover table-striped">
    <thead class="table-success">
        <th scope="col">
            Date
        </th>
        <th scope="col">
           type 
        </th>
        <th scope="col">
            Montant
        </th>
        <th scope="col">
            Action
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
                <td>{{ $operation->amount / 100 }} E</td>
                <td>
                    <a href="{{ route('operations.edit', $operation->id) }}" class="btn btn-success">Editer</a>
                    <a href="#" id="delete-operation-{{ $operation->id}}" class="btn btn-danger ml-5">Supprimer</a>
                </td>
            </tr>

            @if ($next == count($operations) || $operations[$next]->entry_date != $operation->entry_date)
                <tr>
                    <td colspan="4"><b>Total</b> {{ $operation->getDailyAmount() / 100 }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<form id="deleteOperation" action="{{ url('/') }}/operations/" method="post">
	@method('delete')
	@csrf
</form>