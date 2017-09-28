var supportUs = (function () {
    var currency;
    var currencyMultiply;

    var initCorporate = function(corporateCurrency) {
        currency = corporateCurrency;

        switch (currency) {
            case 'US$':
                currency = '$';
                currencyMultiply = 1.2;
                break;
            case 'CA$':
                currency = '$';
                currencyMultiply = 1.5;
                break;
            case 'AU$':
                currency = '$';
                currencyMultiply = 1.5;
                break;
            case '¥':
                currencyMultiply = 130;
                break;
            case '£':
                currencyMultiply = 0.9;
                break;
            default:
                currencyMultiply = 1;
        }

        corporateUpdate(3);
        corporateSlider();
    };

    var corporateSlider = function() {
        $('#slider').slider({
          animate: true,
          value: 3,
          min: 1,
          max: 20,
          step: 1,
          slide: function(event, ui) {
              corporateUpdate(ui.value); //changed
          },
        });
    };

    var corporateUpdate = function(val) {
        var name = '';
        var days = 0;
        var amount = val * 1000;
        var amount1 = 1000;
        var amount2 = 3000;
        var amount3 = 8000;
        var amount4 = 20000;
        var logo1 = amount1 - amount;
        var logo2 = amount2 - amount;
        var logo3 = amount3 - amount;
        var logo4 = amount4 - amount;
        var priority2 = amount2 - amount;
        var priority3 = amount3 - amount;
        var priority4 = amount4 - amount;
        var memberships = amount / 100;
        var voteright = amount / 2 / 10 * 5;

        // Sponsor type
        if (amount>=amount4) {
            name = 'Gold Sponsor';
            days = 10 + (amount - amount4) / 1000 * 0.5;
        } else if (amount >= amount3) {
            name = 'Silver Sponsor';
            days = 5 + (amount - amount3) / 1000 * 0.5;
        } else if (amount >= amount2) {
            name = 'Bronze Sponsor';
            days = 2 + (amount - amount2) / 1000 * 0.5;
        } else if ( amount >= amount1) {
            name = 'Sponsor';
            days = amount / 1000 * 0.5;
        }

        // Display sponsor name
        var total = { value: '<b><span class="sponsor-name">' + name + '</span></b>, 1 year<br>' };

        // Memberships
        add(total, memberships + ' <a href="' + Routing.generate('supportUs_faq') + '#membership">individual memberships</a>', 0);

        // Vote rights
        add(total, voteright + ' <a href="' + Routing.generate('supportUs_faq') + '#votes">vote rights</a>', 0);

        // Days of support
        if (priority4 <= 0) {
            add(total, days + ' days of <a href="' + Routing.generate('ma_professional_services') + '#gold">Gold support</a>', priority4);
        } else if (priority3 <= 0) {
            add(total, days + ' days of <a href="' + Routing.generate('ma_professional_services') + '#silver">Silver support</a>', priority3, 'Gold support', priority4);
        } else if (priority2 <= 0) {
            add(total, days + ' days of <a href="' + Routing.generate('ma_professional_services') + '#bronze">Bronze support</a>', priority2, 'Silver support', priority3);
        } else {
            add(total, days + ' days of <a href="' + Routing.generate('ma_professional_services') + '#basic">Basic support</a>', 0, 'Bronze support', priority2);
        };

        // Logo on sponor page
        if (logo4 <= 0) {
            add(total, '<a href="' + Routing.generate('supportUs_sponsors_list') + '#gold">Large logo</a> on Sponsors page', logo4);
        } else if (logo3 <= 0) {
            add(total, '<a href="' + Routing.generate('supportUs_sponsors_list') + '#silver">Large logo</a> on Sponsors page', logo3);
        } else if (logo2 <= 0) {
            add(total, '<a href="' + Routing.generate('supportUs_sponsors_list') + '#bronze">Medium logo</a> on Sponsors page', logo2, 'large logo', logo3);
        } else {
            add(total, '<a href="' + Routing.generate('supportUs_sponsors_list') + '#sponsor">Small logo</a> on Sponsors page', logo1, 'medium logo', logo2);
        }

        // Logo on all pages
        add(total, 'Small logo on all MediaArea tools pages', logo4);

        total.value += '<br>' +
            '<b>Early bird</b> (expiring 2017-12-31) advantages:<br>' +
            '&#x2611; Membership and support extended to 2019-06-30<br>' +
            '&#x2611; Vote rights x1.5' +
            '<br><br>' +
            '<b>Early adopter</b> (expiring 2018-06-30) advantages:<br>' +
            '&#x2611; Membership and support extended to 2019-06-30';


        $('#corporate-label').html(total.value);

        // Slider label with amount
        $('#slider a').html(
            '<label><span class="glyphicon glyphicon-chevron-left"></span> ' +
            displayAmountWithCurrency(amount) +
            ' <span class="glyphicon glyphicon-chevron-right"></span></label>'
        );

        // Request quote
        $('a.corporate-quote-btn').attr('href', 'mailto:info@mediaarea.net?Subject=Request%20quote%20for%20' + name +'%20(' + displayAmountWithCurrency(amount) + ')');
    };

    var initIndividual = function(individualCurrency) {
        currency = individualCurrency;

        switch (currency) {
            case 'US$':
                currency = '$';
                currencyMultiply = 1;
                break;
            case 'CA$':
                currency = '$';
                currencyMultiply = 1.2;
                break;
            case 'AU$':
                currency = '$';
                currencyMultiply = 1.2;
                break;
            case '¥':
                currencyMultiply = 100;
                break;
            case '£':
                currencyMultiply = 1;
                break;
            default:
                currencyMultiply = 1;
        }

        individualUpdate(3);
        individualSlider();
    };

    var individualSlider = function() {
        $('#slider').slider({
            animate: true,
            value:4,
            min: 0,
            max: 22,
            step: 1,
            slide: function(event, ui) {
                individualUpdate(ui.value); //changed
            }
        });
    };

    var individualUpdate = function(val) {
        var amount = val;
        var amount1 = 10;
        var amount2 = 50;
        var amount3 = 250;
        var amount4 = 500;
        if (amount >= 15) {
            amount = (amount - 12) * 50;
        } else if ( amount >= 7) {
            amount = (amount - 4) * 10;
        } else if (amount >= 3) {
            amount = (amount - 2) * 5;
        }

        var name = 'Thanks!';
        if (amount >= amount4) {
            name = 'Supporter liking links and logos ;-)';
        } else if (amount >= amount3) {
            name = 'Supporter liking links ;-)';
        } else if (amount >= amount2) {
            name = 'Supporter';
        } else if (amount>=amount1) {
            name = 'Member';
        }

        var noad = 1 - amount;
        var member1 = 10 - amount;
        var member2 = 15 - amount;
        var member3 = 20 - amount;
        var supporter = 50 - amount;
        var link = 250 - amount;
        var logo = 500 - amount;
        var vote = 30 - amount;
        var vote1 = 30 - amount;
        var voteright = (amount - 20) / 10 * 5;
        if (voteright < 5) {
            voteright = 5;
        }

        // Payment buttons
        if (0 >= amount) {
            $('.form-group.pay').addClass('hidden');
            $('.form-group.no-pay').removeClass('hidden');
        } else {
            $('.form-group.no-pay').addClass('hidden');
            $('.form-group.pay').removeClass('hidden');
        }

        // Display supporter name
        var total = { value: '<b><span class="supporter-name">' + name + '<span></b><br>' };

        // No ad
        if (noad <= -10 + 1) {
            add(total, 'No ads.', noad);
        } else {
            add(total, 'No ads, 1 year. Every little bit helps.', noad);
        }

        // Membership
        if (member3 <= 0) {
            add(total, '<a href="' + Routing.generate('supportUs_faq') + '#membership">MediaArea member</a> during 3 years', member3);
        } else if (member2 <= 0) {
            add(total, '<a href="' + Routing.generate('supportUs_faq') + '#membership">MediaArea member</a> during 2 years', member2, '3 years', member3);
        } else {
            add(total, '<a href="' + Routing.generate('supportUs_faq') + '#membership">MediaArea member</a> during 1 year', member1, '2 years', member2);
        }

        // Vote rights
        add(total, voteright + ' <a href="' + Routing.generate('supportUs_faq') + '#votes">vote rights</a>', vote1);

        // Supporter page name
        add(total, '<a href="' + Routing.generate('supportUs_supporters_list') + '#name">Your name</a> on Supporters page, 1 year', supporter);

        // Supporter page link
        add(total, '<a href="' + Routing.generate('supportUs_supporters_list') + '#link">Link to your website</a> on Supporters page, 1 year', link);

        // Supporter page logo
        add(total, '<a href="' + Routing.generate('supportUs_supporters_list') + '#logo">Your logo</a> on Supporters page, 1 year', logo);

        total.value += '<br>';
        if (member1 <= 0) {
            total.value += '<b>Early bird</b> (expiring 2017-12-31) advantages:<br>';

            if (member3 <= 0) {
                total.value += '&#x2611; Membership extended to 2021-12-31<br>';
            } else if (member2 <= 0) {
                total.value += '&#x2611; Membership extended to 2020-12-31<br>';
            } else {
                total.value += '&#x2611; Membership extended to 2019-12-31<br>';
            }

            if (vote1 <= 0) {
                total.value += '&#x2611; Vote rights x1.5<br>';
            } else {
                total.value += '<br>';
            }
        } else {
            total.value += '<br><br><br>';
        }

        $('#total-label').html(total.value);

        // Slider label with amount
        $('#slider a').html(
            '<label><span class="glyphicon glyphicon-chevron-left"></span> ' +
            displayAmountWithCurrency(amount) +
            ' <span class="glyphicon glyphicon-chevron-right"></span></label>'
        );
    };

    var displayAmountWithCurrency = function(amount) {
        if ('' == currency) {
            return currency + amount * currencyMultiply;
        }

        return amount * currencyMultiply + ' ' + currency;
    };

    var add = function(obj, text, value, text2, value2) {
        if (value <= 0) {
            obj.value += '&#x2611; ' + text;

            if (typeof value2 != 'undefined') {
                if (value2 <= 0) {
                    obj.value += '';
                } else {
                    obj.value += ' (add ' + displayAmountWithCurrency(value2) + ' for ' + text2 +  ')';
                }
            }
        } else {
            obj.value += '&#x2610; <s>' + text + '</s> (add ' + displayAmountWithCurrency(value) + ')';
        }

        obj.value += '<br>';
    };

      return {
          initCorporate: initCorporate,
          initIndividual: initIndividual,
      };
})();
