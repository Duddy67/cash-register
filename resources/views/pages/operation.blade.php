<h1>Entrée de fond de caisse</h1>

<div class="container">

<form method="post" action="" id="itemForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-8">
            <div class="form-group w-100">
                <label for="operationType">Type d'opération</label>
                <select class="form-control" name="type" id="operationType">
                  <option value="cash_deposit">Dépôt de caisse</option>
                  <option value="delivery_in_bank">Retour en banque</option>
                  <option value="withdrawal">Retrait</option>
                </select>
              </div>
              <div class="form-group w-100">
                  <label for="comment">Commentaire</label>
                  <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
              </div>
          </div>
          <div class="col-4">
              <div id="operation-total" class="h1 total">0 E</div>
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
</form>

</div>