/* Book Manager Plugin JavaScript */

jQuery(document).ready(function ($) {

    $('#requestInfoBtn').click(function () {

        $.post(bookManager.ajaxUrl, {
            action: 'book_request_info',
            nonce: bookManager.nonce,
            book_id: bookManager.bookId
        }, 
        function (response) {

            if (response && response.success) {
                alert(response.data.message);
            } else {
                alert('Something went wrong');
            }

        });

    });

});
