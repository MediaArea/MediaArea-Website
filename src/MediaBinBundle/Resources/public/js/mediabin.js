var MediaBin = (function () {
    var MediaInfoModule, MI, filename, binHash, processing = false, CHUNK_SIZE = 1024 * 1024;

    // Initialize emscripten module
    var init = function(memFile, xml, file, hash) {
        binHash = hash;
        var locateFile = function() {
          return memFile;
        };

        MediaInfoModule = MediaInfoLib({'locateFile': locateFile, 'postRun': function() {
            initPage();
            loadXML(xml, file);
        }});
    };

    // Page init
    var initPage = function() {
        $(document).ready(function() {
            // Format list
            var formatList = JSON.parse(MediaInfoModule.MediaInfo.Option_Static('Info_OutputFormats_JSON'));
            $.each(formatList.output, function(key, format) {
                // Change format list
                $('#mediainfo-format-list').append($('<option>', { value: format.name, mime: format.mime }).text(format.desc));

                // Download format list
                $('.mediainfo-format-list-download-container ul').append(
                    '<li data-format="' + format.name + '" data-mime="' + format.mime + '"><a href="#">' + format.desc + '</a></li>'
                );
            });

            bindings();

            $('.mediainfo-tools-container-temp').addClass('hidden');
            $('.mediainfo-tools-container').removeClass('hidden');
        });
    };

    var bindings = function() {
        // Change output format
        $('#mediainfo-format-list').on('change', function() {
            if (processing) {
                changeOutputFormat($(this).val(), $(this).find(':selected').attr('mime'));
            }
        });

        // Download report format
        $('.mediainfo-format-list-download-container ul li').on('click', function(e) {
            e.preventDefault();

            if (processing) {
                downloadReport(e.currentTarget.getAttribute('data-format'), e.currentTarget.getAttribute('data-mime'));
            }
        });

        // Download report
        $('.mediainfo-format-list-download').on('click', function(e) {
            e.preventDefault();

            if (processing) {
                if ($('#mediainfo-format-list :selected').length) {
                    var format = $('#mediainfo-format-list :selected').val();
                    var mime = $('#mediainfo-format-list :selected').attr('mime');
                } else {
                    var format = 'Text';
                    var mime = 'text/plain';
                }
                downloadReport(format, mime);
            }
        });

        // Copy to clipboard
        var clipboard = new Clipboard('.mediainfo-copy-to-clipboard', {
            text: function() {
                if (processing) {
                    MI.Option('Inform', $('#mediainfo-format-list').val());
                    return MI.Inform();
                }

                return false;
            }
        });
        $('.mediainfo-copy-to-clipboard').tooltip({trigger: 'manual'});

        // Display tooltip on copy
        clipboard.on('success', function() {
            $('.mediainfo-copy-to-clipboard').tooltip('show');
            setTimeout(function() {
                $('.mediainfo-copy-to-clipboard').tooltip('hide');
            }, 2000);
        });

        // MediaBin update
        $('.mediabin-update').on('click', function(e) {
            e.preventDefault();

            $.post(Routing.generate('mediabin_api_update', {hash: binHash}), {
                expiration: $('.mediabin-expiration-edit').hasClass('hidden') ? $('.mediabin-expiration').val() : false,
                title: $('.mediabin-title').val(),
                visibility: $('.mediabin-visibility').val(),
                anonymize: $('#mediabin-anonymize').prop('checked') ? 1 : 0
            })
            .done(function(data) {
                $('.mediabin-error').addClass('hidden');
                $('.mediabin-delete-success').addClass('hidden');
                $('.mediabin-delete-error').addClass('hidden');
                $('.mediabin-success').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();

                // Reload output for anonymize param
                if ($('#mediabin-anonymize').prop('checked')) {
                    MI.Option('HideParameter', 'General_CompleteName');
                    displayReport($('#mediainfo-format-list').find(':selected').attr('mime'));
                    $('.mediabin-reload').addClass('hidden');
                } else {
                    if (MI.Get('Stream_General', 0, 'CompleteName')) {
                        MI.Option('ShowParameter', 'General_CompleteName');
                        displayReport($('#mediainfo-format-list').find(':selected').attr('mime'));
                        $('.mediabin-reload').addClass('hidden');
                    } else {
                        $('.mediabin-reload').removeClass('hidden');
                    }
                }
            })
            .fail(function() {
                $('.mediabin-success').addClass('hidden');
                $('.mediabin-delete-success').addClass('hidden');
                $('.mediabin-delete-error').addClass('hidden');
                $('.mediabin-error').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();
            });
        });

        // MediaBin delete
        $('.mediabin-delete').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: Routing.generate('mediabin_api_delete', {hash: binHash}),
                method: 'DELETE',
            })
            .done(function(data) {
                $('.mediabin-delete').addClass('hidden');
                $('.mediabin-update').addClass('hidden');
                $('.mediabin-error').addClass('hidden');
                $('.mediabin-success').addClass('hidden');
                $('.mediabin-delete-error').addClass('hidden');
                $('.mediabin-cancel').removeClass('hidden');
                $('.mediabin-delete-success').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();
                $('.mediabin-expiration-date').text(data.binExpiration);
            })
            .fail(function() {
                $('.mediabin-error').addClass('hidden');
                $('.mediabin-success').addClass('hidden');
                $('.mediabin-delete-success').addClass('hidden');
                $('.mediabin-delete-error').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();
            });
        });

        // MediaBin cancel deletion
        $('.mediabin-cancel').on('click', function(e) {
            e.preventDefault();

            $.post(Routing.generate('mediabin_api_cancel_expiration', {hash: binHash}))
            .done(function(data) {
                $('.mediabin-error').addClass('hidden');
                $('.mediabin-delete-success').addClass('hidden');
                $('.mediabin-delete-error').addClass('hidden');
                $('.mediabin-cancel-error').addClass('hidden');
                $('.mediabin-cancel-success').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();
                $('.mediabin-cancel').addClass('hidden');
                $('.mediabin-delete').removeClass('hidden');
                $('.mediabin-update').removeClass('hidden');
                $('.mediabin-expiration-date').text(data.binExpiration);
            })
            .fail(function() {
                $('.mediabin-success').addClass('hidden');
                $('.mediabin-error').addClass('hidden');
                $('.mediabin-delete-success').addClass('hidden');
                $('.mediabin-delete-error').addClass('hidden');
                $('.mediabin-cancel-success').addClass('hidden');
                $('.mediabin-cancel-error').removeClass('hidden').fadeIn(0).delay(5000).fadeOut();
            });
        });

        // MediaBin panel
        $('.mediabin-container .panel-heading').on('click', function(e) {
            e.preventDefault();

            $('#mediabin-panel').collapse('toggle');
        });

        $('.mediabin-expiration-edit').on('click', function(e) {
            $('.mediabin-expiration-edit').addClass('hidden');
            $('.mediabin-expiration').removeClass('hidden');
            $('.mediabin-expiration-cancel').removeClass('hidden');
        });

        $('.mediabin-expiration-cancel').on('click', function(e) {
            $('.mediabin-expiration').addClass('hidden');
            $('.mediabin-expiration-cancel').addClass('hidden');
            $('.mediabin-expiration-edit').removeClass('hidden');
        });

        // MediaBin copy bin URL to clipboard
        var clipboardMediaBinUrl = new Clipboard('.mediabin-url-copy-to-clipboard');
        $('.mediabin-url-copy-to-clipboard').tooltip({trigger: 'manual'});

        // Display tooltip on copy
        clipboardMediaBinUrl.on('success', function() {
            $('.mediabin-url-copy-to-clipboard').tooltip('show');
            setTimeout(function() {
                $('.mediabin-url-copy-to-clipboard').tooltip('hide');
            }, 2000);
        });

        // Popovers
        $('[data-toggle="popover"]').popover();
    };

    var finish = function() {
        MI.Close();
        MI.delete;
        processing = false;
    };

    // parseFile callback
    var showResult = function() {
        var mime = 'text/plain';
        if ($('#mediainfo-format-list').val()) {
            MI.Option('Inform', $('#mediainfo-format-list').val());
            mime = $('#mediainfo-format-list :selected').attr('mime');
        }

        displayReport(mime);
        $('.mediainfo-format-list-download-container').removeClass('hidden');
        $('.mediainfo-copy-to-clipboard-container').removeClass('hidden');
    };

    // Change output format
    var changeOutputFormat = function(format, mime) {
        MI.Option('Inform', format);
        displayReport(mime);
    };

    // Display the report
    var displayReport = function(mime) {
        switch(mime) {
            case 'text/html':
                $('#mediainfo-report').html(sanitizeHtmlReport(MI.Inform()));
                break;
            case 'text/xml':
                $('#mediainfo-report').text(MI.Inform());
                break;
            case 'text/json':
                $('#mediainfo-report').text(MI.Inform());
                break;
            default:
                $('#mediainfo-report').text(MI.Inform());
        }
        $('.mediainfo-report-error').addClass('hidden')
        $('#mediainfo-report').removeClass();
        hljs.highlightBlock($('#mediainfo-report')[0]);
    };

    // Sanitize HTML report
    var sanitizeHtmlReport = function(report) {
        report = report.replace(/width="150"/ig, 'width="50%"');
        report = report.replace(/colspan="3"/ig, '');
        report = report.replace(/border:1px solid Navy/ig, 'border:1px solid #0070bb');

        return report;
    };

    // Download report
    var downloadReport = function(format, mime) {
        try {
            var isFileSaverSupported = !!new Blob;
        } catch (e) {
            displayError('Your browser is not compatible. Please update your browser or use another browser.')
        }

        MI.Option('Inform', format);
        var blob = new Blob([MI.Inform()], {type: mime + ';charset=utf-8'});
        saveAs(blob, getReportFilename(format, mime));
    };

    // Get file extension
    var getFileExtensionFromMimeType = function(mime) {
        switch(mime) {
            case 'text/html':
                return 'html';
                break;
            case 'text/xml':
                return 'xml';
                break;
            case 'text/json':
                return 'json';
                break;
            default:
                return 'txt';
        }
    };

    // Get report filename
    var getReportFilename = function(format, mime) {
        var reportFilename = filename + '_MediaInfo';
        var standardReport = ['XML', 'MIXML', 'Text', 'HTML'];
        if (standardReport.indexOf(format) === -1) {
            reportFilename += '.' + format;
        }

        return reportFilename + '.' + getFileExtensionFromMimeType(mime);
    };

    //Display error message
    var displayError = function(error) {
        $('.mediainfo-report-error').text(error);
        $('.mediainfo-report-container').addClass('hidden');
        $('.mediainfo-format-list-download-container').addClass('hidden');
        $('.mediainfo-copy-to-clipboard-container').addClass('hidden');
        $('.mediainfo-report-error').removeClass('hidden')
    };

    // Load MI XML
    var loadXML = function(xml, file) {
        processing = true;
        filename = file;

        // Initialise MediaInfo
        MI = new MediaInfoModule.MediaInfo();
        MI.Open_Buffer_Init(xml.length, 0);
        try {
            MI.Option('Input_Compressed', 'zlib+base64');
            MI.Open_Buffer_Continue(xml);
            MI.Open_Buffer_Finalize();
            showResult();
        } catch(e) {
            finish();
            displayError('An error happened loading this MediaBin.');
            return;
        }
    };

    return {
        init: init,
    };
});
