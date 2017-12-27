var pastebin = (function () {
    var MediaInfoModule, MI, filename, processing = false, CHUNK_SIZE = 1024 * 1024;

    // Initialize emscripten module
    var init = function(memFile, xml, file) {
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

            $('div.mediainfo-loader').remove();
            $('div.mediainfo-container').removeClass('hidden');
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

        $('.mediainfo-report-filename').text(filename);
        $('.mediainfo-report-filename-container').removeClass('hidden');

        displayReport(mime);
        $('.mediainfo-report-container').removeClass('hidden');
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
        $('.mediainfo-report-filename-container').addClass('hidden');
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
            MI.Open_Buffer_Continue(xml);
            MI.Open_Buffer_Finalize();
            showResult();
        } catch(e) {
            finish();
            displayError('An error happened loading your pastebin.');
            return;
        }
    };

    return {
        init: init,
    };
});
