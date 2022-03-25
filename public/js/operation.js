(function($) {
    let note;
    let coin;
    let cent;

    // Run a function when the page is fully loaded including graphics.
    $(window).on('load', function() {
    
        note = new CRepeater.init({
            item:'note',
            rowsCells: [3],
        });

        note.createItem();
  
        coin = new CRepeater.init({
            item:'coin',
            rowsCells: [3],
        });

        coin.createItem();
  
        cent = new CRepeater.init({
            item:'cent',
            rowsCells: [3],
        });

        cent.createItem();
    });

    populateNoteItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        let attribs = {'title': 'Numéral', 'class':'item-label', 'id':'note-numeral-label-'+idNb};
        document.getElementById('note-row-1-cell-1-'+idNb).append(note.createElement('span', attribs));
        document.getElementById('note-numeral-label-'+idNb).textContent = 'Numéral';

        attribs = {'name':'note_numeral_'+idNb, 'id':'note-numeral-'+idNb, 'class':'form-control'};
        let elem = note.createElement('select', attribs);

        const numerals = [5, 10, 20, 50, 100, 200, 500];
        let options = '';

        numerals.forEach(numeral => {
            let selected = '';

            if (data.numeral == numeral) {
                selected = 'selected="selected"';
            }

            options += '<option value="'+numeral+'" '+selected+'>'+numeral+'</option>';
        });

        $('#note-row-1-cell-1-'+idNb).append(elem);
        $('#note-numeral-'+idNb).html(options);

        attribs = {'title': 'Quantité', 'class':'item-label', 'id':'note-quantity-label-'+idNb};
        document.getElementById('note-row-1-cell-2-'+idNb).append(note.createElement('span', attribs));
        document.getElementById('note-quantity-label-'+idNb).textContent = 'Quantité';

        attribs = {'type':'text', 'name':'note_quantity_'+idNb, 'id':'note-quantity-'+idNb, 'class':'form-control', 'value':data.quantity};
        $('#note-row-1-cell-2-'+idNb).append(note.createElement('input', attribs));
    }
  
    populateCoinItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        let attribs = {'title': 'Numéral', 'class':'item-label', 'id':'coin-numeral-label-'+idNb};
        document.getElementById('coin-row-1-cell-1-'+idNb).append(coin.createElement('span', attribs));
        document.getElementById('coin-numeral-label-'+idNb).textContent = 'Numéral';

        attribs = {'name':'coin_numeral_'+idNb, 'id':'coin-numeral-'+idNb, 'class':'form-control'};
        let elem = coin.createElement('select', attribs);

        const numerals = [1, 2];
        let options = '';

        numerals.forEach(numeral => {
            let selected = '';

            if (data.numeral == numeral) {
                selected = 'selected="selected"';
            }

            options += '<option value="'+numeral+'" '+selected+'>'+numeral+'</option>';
        });

        $('#coin-row-1-cell-1-'+idNb).append(elem);
        $('#coin-numeral-'+idNb).html(options);

        attribs = {'title': 'Quantité', 'class':'item-label', 'id':'coin-quantity-label-'+idNb};
        document.getElementById('coin-row-1-cell-2-'+idNb).append(coin.createElement('span', attribs));
        document.getElementById('coin-quantity-label-'+idNb).textContent = 'Quantité';

        attribs = {'type':'text', 'name':'coin_quantity_'+idNb, 'id':'coin-quantity-'+idNb, 'class':'form-control', 'value':data.quantity};
        $('#coin-row-1-cell-2-'+idNb).append(coin.createElement('input', attribs));
    }
  
    populateCentItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        let attribs = {'title': 'Numéral', 'class':'item-label', 'id':'cent-numeral-label-'+idNb};
        document.getElementById('cent-row-1-cell-1-'+idNb).append(cent.createElement('span', attribs));
        document.getElementById('cent-numeral-label-'+idNb).textContent = 'Numéral';

        attribs = {'name':'cent_numeral_'+idNb, 'id':'cent-numeral-'+idNb, 'class':'form-control'};
        let elem = cent.createElement('select', attribs);

        const numerals = [1, 2, 5, 10, 20, 50];
        let options = '';

        numerals.forEach(numeral => {
            let selected = '';

            if (data.numeral == numeral) {
                selected = 'selected="selected"';
            }

            options += '<option value="'+numeral+'" '+selected+'>'+numeral+'</option>';
        });

        $('#cent-row-1-cell-1-'+idNb).append(elem);
        $('#cent-numeral-'+idNb).html(options);

        attribs = {'title': 'Quantité', 'class':'item-label', 'id':'cent-quantity-label-'+idNb};
        document.getElementById('cent-row-1-cell-2-'+idNb).append(cent.createElement('span', attribs));
        document.getElementById('cent-quantity-label-'+idNb).textContent = 'Quantité';

        attribs = {'type':'text', 'name':'cent_quantity_'+idNb, 'id':'cent-quantity-'+idNb, 'class':'form-control', 'value':data.quantity};
        $('#cent-row-1-cell-2-'+idNb).append(cent.createElement('input', attribs));
    }
  
  })(jQuery);