(function($) {

    // Run a function when the page is fully loaded including graphics.
    $(window).on('load', function() {
    
        $(document).on('click', '[id^="delete-operation-"]', function(event) {
            event.preventDefault();
            // Get the id number from the element id attribute.
            const operationId = $(this).attr('id').split('-')[2];
            const form = $('#deleteOperation');
            // Set the operation id for deletion.
            form.attr('action', form.attr('action')+operationId);
            // Delete the operation.
            form.submit();
        });
    });

  })(jQuery);