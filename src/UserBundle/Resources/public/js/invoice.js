$(document).ready(function() {
    $('.btn-print').click(function() {
        $('.modal-body').printThis({
            pageTitle: 'MediaArea invoice',
        });
    });

    $('.btn-dld').click(function() {
        var invoiceId = $('#invoiceModal .invoice-data-id').text();
        window.location = Routing.generate('invoice_download_pdf', { id: invoiceId });
    });

    $('#invoiceModal').on('show.bs.modal', function (event) {
      var invoiceId = $(event.relatedTarget).data('invoice-id');
      var modal = $(this);

      modal.find('.modal-invoice-success').addClass('hidden');
      modal.find('.btn-print').addClass('hidden');

      $.get(Routing.generate('invoice_ajax_modal_data', { id: invoiceId }))
          .done(function(data) {
              modal.find('.modal-invoice-error').addClass('hidden');

              modal.find('.invoice-data-id').text(invoiceId);
              modal.find('.invoice-data-currency').text(data.currency);
              modal.find('.invoice-data-date').text(data.date);
              modal.find('.invoice-data-product').text(data.product);
              modal.find('.invoice-data-amount').text(data.amount);
              modal.find('.invoice-data-vat').text(data.vat);
              modal.find('.invoice-data-total').text(data.total);
              modal.find('.invoice-data-country').text(data.country);

              modal.find('.modal-invoice-success').removeClass('hidden');
              modal.find('.btn-print').removeClass('hidden');
          })
          .fail(function(data) {
              modal.find('.modal-invoice-error').removeClass('hidden');
          });
    })
});
