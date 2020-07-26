/*
*  Document   : ticket_index_page.js
*  Author     : rabii@rc2k
*  Description: Custom JS code used in tickets/index page
*/

function getData(page) {

    $('#tickets_list_block').addClass('block-mode-loading');

    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
    }).done(function (data) {
        $('#tickets_list_block').removeClass('block-mode-loading');
        $("#tickets_list_wrapper").empty().html(data);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        $('#tickets_list_block').removeClass('block-mode-loading');
        alert('No response from server');
    });
}

class indexTicketPage {

    /*
    * Init Events listeners
    *
    */
    static initEventsListeners() {

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();

            $('li').removeClass('active');
            $(this).parent('li').addClass('active');

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            getData(page);
        });

    }

    /*
    * Init functionality
    *
    */
    static init() {
        this.initEventsListeners();
    }
}

// Initialize when page loads
jQuery(() => {
    indexTicketPage.init();
});
