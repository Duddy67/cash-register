(function($) {
    let note;
    let coin;
    let cent;

    // Run a function when the page is fully loaded including graphics.
    $(window).on('load', function() {
    
        // Create a repeater instance for each currency item.

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

        // Edit an operation.
        if ($('#note_data').length > 0) {
            // Load the corresponding data for each currency item and create them.

            let data = JSON.parse($('#note_data').val());
            data.forEach(elem => {
                note.createItem(elem);
            });

            $.fn.setSubTotal('note');
        
            data = JSON.parse($('#coin_data').val());
            data.forEach(elem => {
                coin.createItem(elem);
            });
        
            $.fn.setSubTotal('coin');

            data = JSON.parse($('#cent_data').val());
            data.forEach(elem => {
                cent.createItem(elem);
            });
        
            $.fn.setSubTotal('cent');
            $.fn.setTotalAmount();
        }
        // Create a new operation. 
        else {
            // Create default currency items.
            note.createItem();
            coin.createItem();
            cent.createItem();
        }

        // Check for changings in selects and inputs then update subtotal and total values accordingly.

        $(document).on('input', '[id*="-quantity-"]', function(event) {
            // First check for a valid number.
            const num = Number($(this).val());
            if (!Number.isInteger(num)) {
                alert('Nombre: '+$(this).val()+' non valide');
                $(this).val(0);
            }

            // Get the currency item from the element id.
            const currencyItem = $(this).attr('id').split('-')[0];
            $.fn.setSubTotal(currencyItem);
            $.fn.setTotalAmount();
        });

        $(document).on('change', '[id*="-numeral-"]', function(event) {
            // Get the currency item from the element id.
            const currencyItem = $(this).attr('id').split('-')[0];
            $.fn.setSubTotal(currencyItem);
            $.fn.setTotalAmount();
        });

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        }).on('hide', function(e) {
            // Get the picked date.
            let date = $('#datepicker').val();
            // Convert it into MySQl format (Y-m-d).
            date = date.split('/');
            date = date[2]+'-'+date[1]+'-'+date[0];
            $('#entry-date').val(date);
        });

        // Set the current entry date.
        let entryDate = $('#entry-date').val();
        if (entryDate) {
            entryDate = entryDate.split('-');
            entryDate = entryDate[2]+'/'+entryDate[1]+'/'+entryDate[0];
            $('#datepicker').val(entryDate);
        }

        $(document).on('submit', '#operationForm', function(event) {
            // Ensure the entry date field is filled out.
            if ($('#entry-date').val() == '') {
                $('.datepicker').css('border', '1px solid red');
                event.preventDefault();
                event.stopPropagation();

                alert('Le champ date est obligatoire');
            }
        });
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
  
    afterRemoveItem = function(idNb, itemType) {
        // Reset the subtotal and total values.
        $.fn.setSubTotal(itemType);
        $.fn.setTotalAmount();
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

    $.fn.getSubTotal = function(currencyItem) {
        let subTotal = 0;
        $('[id^="'+currencyItem+'-numeral-"]').each(function() {

            // Skip the label tags.
            if ($(this).val() != '') {
                const idNb = $(this).attr('id').split('-')[2];
                subTotal += $(this).val() * $('#'+currencyItem+'-quantity-'+idNb).val();
            }
        });

        return subTotal;
    }

    $.fn.setSubTotal = function(currencyItem) {
        let subTotal = $.fn.getSubTotal(currencyItem);

        if (currencyItem == 'cent') {
            // Convert in decimal value.
            subTotal = subTotal / 100;
            subTotal = $.fn.zeroPadding(subTotal);
        }

        $('#'+currencyItem+'-subtotal').text(subTotal);
    }

    $.fn.setTotalAmount = function() {
        let total = 0;
        const currencyItems = ['note', 'coin', 'cent'];

        currencyItems.forEach(currencyItem => {
            if (currencyItem == 'cent') {
                // Convert the total in cents before adding the cent value.
                total = total * 100;
            }
            
            total += $.fn.getSubTotal(currencyItem);
        });

        total = total / 100;
        
        $('#total-amount').text($.fn.zeroPadding(total));
    }

    // Possibly adds an extra zero after the first cent unit (if any).
    $.fn.zeroPadding = function(number) {
        number = String(number);
        decimal = number.split('.')[1];

        if (decimal !== undefined && decimal.length == 1) {
            return number+'0';
        }

        return number;
    }

  })(jQuery);