/**
 * Book Manager — frontend AJAX for the "I'm Interested" button.
 */
(function ($) {
    'use strict';

    $(function () {
        var $btn = $('#book-manager-interest-btn');
        if (!$btn.length || typeof BookManager === 'undefined') {
            return;
        }

        var $status = $('.book-manager-interest-status');

        $btn.on('click', function () {
            $btn.prop('disabled', true).addClass('is-loading');
            $status.text('Sending...');

            $.ajax({
                url: BookManager.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action:  'book_interest',
                    nonce:   BookManager.nonce,
                    book_id: BookManager.bookId
                }
            })
            .done(function (response) {
                if (response && response.success && response.data && response.data.message) {
                    window.alert(response.data.message);
                    $status.text('Thanks for your interest!');
                } else {
                    var msg = (response && response.data && response.data.message)
                        ? response.data.message
                        : 'Something went wrong. Please try again.';
                    $status.text(msg);
                }
            })
            .fail(function () {
                $status.text('Request failed. Please try again.');
            })
            .always(function () {
                $btn.prop('disabled', false).removeClass('is-loading');
            });
        });
    });
})(jQuery);
