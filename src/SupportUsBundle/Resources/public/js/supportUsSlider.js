var supportUs = (function () {
    var currency,
        currencyMultiply;

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
        setSliderPosition(3);
        corporateSlider();
        corporateButtons();
    };

    var corporateSlider = function() {
        $('[data-slider]').bind('slider:ready slider:changed', function (event, data) {
            corporateUpdate(data.value);
        });
    };


    var corporateButtons = function() {
        $('.btn-corporate-bronze').click(function() {
            setSliderPosition(3);
        });
        $('.btn-corporate-silver').click(function() {
            setSliderPosition(8);
        });
        $('.btn-corporate-gold').click(function() {
            setSliderPosition(20);
        });
    };

    var corporateUpdate = function(val) {
        var name = '',
            days = 0,
            amount = val * 1000 * currencyMultiply,
            amount1 = 1000 * currencyMultiply,
            amount2 = 3000 * currencyMultiply,
            amount3 = 8000 * currencyMultiply,
            amount4 = 20000 * currencyMultiply,
            logo1 = amount1 - amount,
            logo2 = amount2 - amount,
            logo3 = amount3 - amount,
            logo4 = amount4 - amount,
            priority2 = amount2 - amount,
            priority3 = amount3 - amount,
            priority4 = amount4 - amount
            memberships = amount / 100 / currencyMultiply,
            voteright = amount / 2 / 10 * 5 / currencyMultiply;

        // Sponsor type
        buttonsHighlightReset();
        if (amount>=amount4) {
            name = 'Gold Sponsor';
            days = 10 + (amount - amount4) / 1000 * 0.5 / currencyMultiply;
            buttonsHighlight('.btn-corporate-gold');
        } else if (amount >= amount3) {
            name = 'Silver Sponsor';
            days = 5 + (amount - amount3) / 1000 * 0.5 / currencyMultiply;
            buttonsHighlight('.btn-corporate-silver');
        } else if (amount >= amount2) {
            name = 'Bronze Sponsor';
            days = 2 + (amount - amount2) / 1000 * 0.5 / currencyMultiply;
            buttonsHighlight('.btn-corporate-bronze');
        } else if ( amount >= amount1) {
            name = 'Sponsor';
            days = amount / 1000 * 0.5 / currencyMultiply;
        }

        // Display sponsor name
        var total = { value: '<span class="sponsor-name">' + displayAmountWithCurrency(amount) + ', <b>' + name + '</span></b>, 1 year<br>' };

        // Memberships
        add(total, memberships + ' <a href="' + Routing.generate('supportUs_faq') + '#membership">individual memberships</a>', 0);

        // Voting points
        add(total, voteright + ' <a href="' + Routing.generate('supportUs_faq') + '#votes">voting points</a>', 0);

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
            '&#x2611; Voting points x1.5' +
            '<br><br>' +
            '<b>Early adopter</b> (expiring 2018-06-30) advantages:<br>' +
            '&#x2611; Membership and support extended to 2019-06-30';


        $('#corporate-label').html(total.value);

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

        individualUpdate(7);
        setSliderPosition(7);
        individualSlider();
        individualButtons();
        paymentButtonsBindings();
    };

    var individualSlider = function() {
        $('[data-slider]').bind('slider:ready slider:changed', function (event, data) {
            individualUpdate(data.value);
        });
    };

    var individualButtons = function() {
        $('.btn-individual-member').click(function() {
            setSliderPosition(4);
        });
        $('.btn-individual-voter').click(function() {
            setSliderPosition(7);
        });
        $('.btn-individual-supporter-bronze').click(function() {
            setSliderPosition(14);
        });
        $('.btn-individual-supporter-silver').click(function() {
            setSliderPosition(18);
        });
        $('.btn-individual-supporter-gold').click(function() {
            setSliderPosition(22);
        });
    };

    var individualUpdate = function(val) {
        var amount = val,
            amount1 = 10 * currencyMultiply,
            amount2 = 30 * currencyMultiply,
            amount3 = 100 * currencyMultiply,
            amount4 = 300 * currencyMultiply,
            amount5 = 500 * currencyMultiply;

        if (amount >= 15) {
            amount = (amount - 12) * 50;
        } else if ( amount >= 7) {
            amount = (amount - 4) * 10;
        } else if (amount >= 3) {
            amount = (amount - 2) * 5;
        }
        amount = Math.round(amount * currencyMultiply);

        var name = 'Thanks!';
        buttonsHighlightReset();
        if (amount >= amount5) {
            name = 'Supporter++';
            buttonsHighlight('.btn-individual-supporter-gold');
        } else if (amount >= amount4) {
            name = 'Supporter+';
            buttonsHighlight('.btn-individual-supporter-silver');
        } else if (amount >= amount3) {
            name = 'Supporter';
            buttonsHighlight('.btn-individual-supporter-bronze');
        } else if (amount >= amount2) {
            name = 'Voter';
            buttonsHighlight('.btn-individual-voter');
        } else if (amount >= amount1) {
            name = 'Member';
            buttonsHighlight('.btn-individual-member');
        } else if (0 == amount) {
            name = false;
        }

        var noad = Math.round(1 * currencyMultiply) - amount,
            member1 = 10 * currencyMultiply - amount,
            member2 = 15 * currencyMultiply - amount,
            member3 = 20 * currencyMultiply - amount,
            supporter = 50 * currencyMultiply - amount,
            link = 250 * currencyMultiply - amount,
            logo = 500 * currencyMultiply - amount,
            vote = 30 * currencyMultiply - amount,
            vote1 = 30 * currencyMultiply - amount,
            voteright = amount / 10 * 5 / currencyMultiply;

        if (voteright < 15) {
            voteright = 15;
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
        if (name) {
            var total = { value: '<span class="supporter-name">' + displayAmountWithCurrency(amount) + ' <b>' + name + '</span></b><br>' };
        } else {
            var total = { value: '<span class="supporter-name">' + displayAmountWithCurrency(amount) + '</span><br>' };
        }

        // No ad
        if (noad <= 9) {
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

        // Voting points
        add(total, voteright + ' <a href="' + Routing.generate('supportUs_faq') + '#votes">voting points</a>', vote1);

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
                total.value += '&#x2611; Voting points x1.5<br>';
            } else {
                total.value += '<br>';
            }
        } else {
            total.value += '<br><br><br>';
        }

        $('#individual-label').html(total.value);

        // Payment buttons update
        $('.btn-paypal').text('Pay ' + displayAmountWithCurrency(amount) + ' with Paypal');
        $('.btn-cb').val('Pay ' + displayAmountWithCurrency(amount) + ' by Credit Card');
        $('#ma_choose_payment_method_amount').val(amount);
        if ($('.btn-bank-wire').length) {
            $('.btn-bank-wire').text(displayAmountWithCurrency(amount) + ' by bank wire');
        }
    };

    var paymentButtonsBindings = function() {
        $('.btn-cb').click(function () {
            $('input[type="radio"][name="ma_choose_payment_method[method]"][value="stripe_credit_card"]').prop('checked', true);
        });
        $('.btn-paypal').click(function () {
            $('input[type="radio"][name="ma_choose_payment_method[method]"][value="paypal_express_checkout"]').prop('checked', true);
            $('form[name="ma_choose_payment_method"]').submit();
        });
    };

    var displayAmountWithCurrency = function(amount) {
        if ('$' == currency) {
            return currency + amount;
        }

        return amount + ' ' + currency;
    };

    var buttonsHighlightReset = function() {
        $('.btn-support-us').removeClass('active');
    };

    var buttonsHighlight = function(btn) {
        $(btn).addClass('active');
    };

    var setSliderPosition = function(pos) {
        $('#slider').simpleSlider('setValue', pos);
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
