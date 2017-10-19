$(document).ready(function() {
    $('.btn-print').click(function() {
        $('.modal-body').printThis({
            pageTitle: 'MediaArea invoice',
        });
    });

    $('#invoiceModal').on('show.bs.modal', function (event) {
      var invoiceId = $(event.relatedTarget).data('invoice-id');
      var modal = $(this);

      modal.find('.modal-invoice-success').addClass('hidden');
      modal.find('.btn-print').addClass('hidden');

      $.get(Routing.generate('invoice_modal_data', { id: invoiceId }))
          .done(function(data) {
              var formatNumber = function(number, currency) {
                  if ('JPY' == currency) {
                      return number.toFixed(0);
                  } else {
                      return number.toFixed(2);
                  }
              };

              modal.find('.modal-invoice-error').addClass('hidden');

              modal.find('.invoice-data-id').text(invoiceId);
              modal.find('.invoice-data-currency').text(data.currency);
              modal.find('.invoice-data-date').text(data.date);
              modal.find('.invoice-data-amount').text(formatNumber(data.amount, data.currency));
              modal.find('.invoice-data-vat').text(formatNumber(data.vat, data.currency));
              modal.find('.invoice-data-total').text(formatNumber(+data.amount + +data.vat, data.currency));
              modal.find('.invoice-data-country').text(data.country);

              modal.find('.modal-invoice-success').removeClass('hidden');
              modal.find('.btn-print').removeClass('hidden');
          })
          .fail(function(data) {
              modal.find('.modal-invoice-error').removeClass('hidden');
          });
    })
});
