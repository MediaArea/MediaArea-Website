var userListing = (function () {
    var init = function(items, limit) {
        if (undefined === limit) {
            var limit = 10;
        }

        $('#pagination-user').pagination({
            items: items,
            itemsOnPage: limit,
            displayedPages: 5,
            cssStyle: '',
            prevText: '<span aria-hidden="true">&lsaquo;</span>',
            nextText: '<span aria-hidden="true">&rsaquo;</span>',
            onPageClick: function (page, event) {
                if (undefined !== event) {
                    event.preventDefault();
                }
                var start = (page - 1) * limit;
                $.get(Routing.generate('mediabin_api_listing_user', {start: start, limit: limit}))
                .done(function(data) {
                    $('#listing-user').html('');
                    $.each(data.list, function(key, bin) {
                        $('#listing-user').append('<li><a href="' + Routing.generate('mediabin_show', {hash: bin.hash}) + '">' + bin.title + '</a></li>');
                    });
                })
            }
        });
    };

    return {
        init: init,
    };
})();

var latestsPublicListing = (function () {
    var init = function(items, limit) {
        if (undefined === limit) {
            var limit = 10;
        }

        // Limit this listing to 100 items
        if (100 <= items) {
            items = 100;
        }

        $('#pagination-latests-public').pagination({
            items: items,
            itemsOnPage: limit,
            displayedPages: 5,
            cssStyle: '',
            prevText: '<span aria-hidden="true">&laquo;</span>',
            nextText: '<span aria-hidden="true">&raquo;</span>',
            onPageClick: function (page, event) {
                if (undefined !== event) {
                    event.preventDefault();
                }
                var start = (page - 1) * limit;
                $.get(Routing.generate('mediabin_api_listing_latests_public', {start: start, limit: limit}))
                .done(function(data) {
                    $('#listing-latests-public').html('');
                    $.each(data.list, function(key, bin) {
                        $('#listing-latests-public').append('<li><a href="' + Routing.generate('mediabin_show', {hash: bin.hash}) + '">' + bin.title + '</a></li>');
                    });
                })
            }
        });
    };

    return {
        init: init,
    };
})();
