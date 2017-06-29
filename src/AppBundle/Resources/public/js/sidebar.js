var sidebar = (function () {
    var display = false;

    var init = function() {
        showSidebar();

        $(window).resize(function () {
            showSidebar();
        });
    };

    var showSidebar = function() {
        setLeftPosition();
        if (1860 <= $(window).width() && false === display) {
            display = true;
            menu();
            social();
            ads();
            scrollMenu();
        }
    };

    var setLeftPosition = function() {
        if (1860 <= $(window).width()) {
            // screen width / 2 - (container width / 2) - #sidebar width - margin
            var pos = $(window).width() / 2 - (1170 / 2) - $('#sidebar').width() - 35;
            $('#sidebar').css('left', pos);
        }
    };

    var menu = function() {
        var menuList = $('#sidebar .sidebar-menu ul');
        $('section.anchor').each(function(index) {
            if (1 <= $(this).children('h1, h2').length) {
                $(menuList).append('<li><a href="#' + $(this).prop('id') + '">' +  $(this).children('h1, h2').first().text() + '</a></li>');
            }

            if (0 == index) {
                $('#sidebar .sidebar-menu').append('<hr>')
            }
        });
    };

    var social = function() {
        $('footer .social-block').clone(true).appendTo('#sidebar .sidebar-social');
    };

    var ads = function() {
        var slot = '<ins class="adsbygoogle"\
             style="display:block;"\
             data-ad-client="ca-pub-8386011224798635"\
             data-ad-slot="3057614716"\
             data-ad-format="auto"></ins>';

        $('#sidebar .sidebar-ads').append(slot);
        (adsbygoogle = window.adsbygoogle || []).push({});
    };

    var scrollMenu = function() {
        var $sidebar = $('#sidebar .sidebar-menu');
        if ($sidebar.length > 0) {
            var $sidebar_a = $sidebar.find('a');

            $sidebar_a
                .addClass('scrolly')
                .on('click', function() {
                    var $this = $(this);

                    // External link? Bail.
                        if ($this.attr('href').charAt(0) != '#')
                            return;

                    // Deactivate all links.
                        $sidebar_a.removeClass('active');

                    // Activate link *and* lock it (so Scrollex doesn't try to activate other links as we're scrolling to this one's section).
                        $this
                            .addClass('active')
                            .addClass('active-locked');

                })
                .each(function() {

                    var $this = $(this),
                        id = $this.attr('href'),
                        $section = $(id);

                    // No section for this link? Bail.
                    if ($section.length < 1)
                        return;

                    // Scrollex.
                    $section.scrollex({
                        mode: 'top',
                        top: -50,
                        bottom: 0,
                        initialize: function() {
                            $section.addClass('inactive');
                        },
                        enter: function() {
                            // Activate section.
                            $section.removeClass('inactive');

                            // No locked links? Deactivate all links and activate this section's one.
                            if ($sidebar_a.filter('.active-locked').length == 0) {
                                $sidebar_a.removeClass('active');
                                $this.addClass('active');
                            }
                            // Otherwise, if this section's link is the one that's locked, unlock it.
                            else if ($this.hasClass('active-locked'))
                                $this.removeClass('active-locked');
                        }
                    });
                });
        }

        // Scrolly.
        $('.scrolly').scrolly({
            speed: 1000,
            offset: 0
        });
    };

    return {
        init: init,
    };
})();

$(document).ready(function() {
    sidebar.init();
});
