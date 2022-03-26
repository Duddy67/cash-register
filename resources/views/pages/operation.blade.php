<h1>Entrée de fond de caisse</h1>

<div class="container">

@php $action = (isset($operation)) ? route('operations.update', $id) : route('operations.store') @endphp
@php $selected = 'selected=selected'; @endphp

<form action="{{ $action }}" id="itemForm" method="post" enctype="multipart/form-data">
    @csrf

    @if (isset($operation))
        @method('put')
    @endif

    <div class="row">
        <div class="col-8">
            <div class="form-group w-100">
                <label for="operationType">Type d'opération</label>
                <select class="form-control" name="type" id="operationType">
                  <option value="cash_deposit" {{ (isset($operation) && $operation->type == 'cash_deposit') ? $selected : '' }}>Dépôt de caisse</option>
                  <option value="delivery_in_bank" {{ (isset($operation) && $operation->type == 'delivery_in_bank') ? $selected : '' }}>Retour en banque</option>
                  <option value="withdrawal" {{ (isset($operation) && $operation->type == 'withdrawal') ? $selected : '' }}>Retrait</option>
                </select>
              </div>
              <div class="form-group w-100">
                  <label for="comment">Date</label>
                  <div class="input-group date" id="datepicker">
                    <input type="text" class="form-control">
                    <span class="input-group-append">
                        <span class="input-group-text bg-white">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </span>
                </div>
              </div>
              <div class="form-group w-100">
                  <label for="comment">Commentaire</label>
                  <textarea class="form-control" name="comment" id="comment" rows="3">{{ (isset($operation)) ? old('comment', $operation->comment) : old('comment') }}</textarea>
              </div>
          </div>
          <div class="col-4">
              <div id="operation-total" class="h1 total">{{ (isset($total)) ? $total : 0 }} E</div>
          </div>
    </div>

    <div class="row">
        <div class="col-12">
          <h3>Billets</h3>
        </div>

        <div class="col-8">
            <div id="note">

            </div>
        </div>
        <div class="col-4">
            <div id="note-subtotal" class="h1 subtotal">0 E</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <h3>Pièces</h3>
        </div>

        <div class="col-8">
            <div id="coin">

            </div>
        </div>
        <div class="col-4">
            <div id="coin-subtotal" class="h1 subtotal">0 E</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <h3>Centimes</h3>
        </div>

        <div class="col-8">
            <div id="cent">

            </div>
        </div>
        <div class="col-4">
            <div id="cent-subtotal" class="h1 subtotal">0 E</div>
        </div>
    </div>

    <input type="submit" value="Enregistrer" />

    @if (isset($operation))
        <input type="hidden" id="note_data" value="{{ json_encode($operation->notes()->select('numeral', 'quantity')->get()->toArray()) }}" />
        <input type="hidden" id="coin_data" value="{{ json_encode($operation->coins()->select('numeral', 'quantity')->get()->toArray()) }}" />
        <input type="hidden" id="cent_data" value="{{ json_encode($operation->cents()->select('numeral', 'quantity')->get()->toArray()) }}" />
    @endif
</form>

</div>