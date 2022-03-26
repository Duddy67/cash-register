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
  
        coin = new CRepeater.init({
            item:'coin',
            rowsCells: [3],
        });
  
        cent = new CRepeater.init({
            item:'cent',
            rowsCells: [3],
        });

        if ($('#note_data').length > 0) {
            let data = JSON.parse($('#note_data').val());
            data.forEach(elem => {
                note.createItem(elem);
            });
        
            data = JSON.parse($('#coin_data').val());
            data.forEach(elem => {
                coin.createItem(elem);
            });
        
            data = JSON.parse($('#cent_data').val());
            data.forEach(elem => {
                cent.createItem(elem);
            });
        
        }
        // Create a new operation. 
        else {
            note.createItem();
            coin.createItem();
            cent.createItem();
        }

        $('#datepicker').datepicker();
    });

    // CRepeater callback functions.

    populateNoteItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        const numerals = [5, 10, 20, 50, 100, 200, 500];
        $.fn.buildItem(note, idNb, data, numerals);
    }
  
    populateCoinItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        const numerals = [1, 2];
        $.fn.buildItem(coin, idNb, data, numerals);
    }
  
    populateCentItem = function(idNb, data) {
        // Defines the default field values.
        if (data === undefined) {
            data = {numeral: '', quantity: 0};
        }

        const numerals = [1, 2, 5, 10, 20, 50];

        $.fn.buildItem(cent, idNb, data, numerals);
    }
  
    $.fn.buildItem = function(item, idNb, data, numerals) {
        let attribs = {'title': 'Numéral', 'class':'item-label', 'id': item._itemType+'-numeral-label-'+idNb};
        $('#'+item._itemType+'-row-1-cell-1-'+idNb).append(item.createElement('span', attribs));
        $('#'+item._itemType+'-numeral-label-'+idNb).text('Numéral');

        attribs = {'name': item._itemType+'_numeral_'+idNb, 'id': item._itemType+'-numeral-'+idNb, 'class': 'form-control'};
        let elem = item.createElement('select', attribs);

        let options = '';

        numerals.forEach(numeral => {
            let selected = '';

            if (data.numeral == numeral) {
                selected = 'selected="selected"';
            }

            options += '<option value="'+numeral+'" '+selected+'>'+numeral+'</option>';
        });

        $('#'+item._itemType+'-row-1-cell-1-'+idNb).append(elem);
        $('#'+item._itemType+'-numeral-'+idNb).html(options);

        attribs = {'title': 'Quantité', 'class':'item-label', 'id': item._itemType+'-quantity-label-'+idNb};
        $('#'+item._itemType+'-row-1-cell-2-'+idNb).append(item.createElement('span', attribs));
        $('#'+item._itemType+'-quantity-label-'+idNb).text('Quantité');

        attribs = {'type':'text', 'name': item._itemType+'_quantity_'+idNb, 'id': item._itemType+'-quantity-'+idNb, 'class':'form-control', 'value':data.quantity};
        $('#'+item._itemType+'-row-1-cell-2-'+idNb).append(item.createElement('input', attribs));
    }

  })(jQuery);