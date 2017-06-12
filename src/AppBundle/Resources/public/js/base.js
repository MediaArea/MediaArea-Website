$(document).ready(function() {
    function isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints;
    };

    //Early return if touch device
    if (isTouchDevice()) {
        return;
    }

    //Open dropdown menu on hover if not touch device & navbar-toggle not visible
    $('#nav ul.nav li.dropdown').hover(function() {
        if (!$('.navbar-toggle').is(':visible') && !$(this).hasClass('open')) {
            $('.dropdown-toggle', this).trigger('click');
        }
    }, function() {
        if (!$('.navbar-toggle').is(':visible') && $(this).hasClass('open')) {
            $('.dropdown-toggle', this).trigger('click');
        }
    });
});
