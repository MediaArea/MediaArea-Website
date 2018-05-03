var MediaCompareBase = (function () {
    var fileId = 0,
        files = [],
        compare,
        analyze,
        list;

    var init = function() {
        dragAndDropBinding();
        fileInputBinding();
        displayChangeBinding();
        $('#mediainfo-loader').remove();
        $('#mediainfo-compare-container').removeClass('hidden');
    };

    var setList = function(value) {
        if (undefined === list) {
            list = value;
        }
    }

    var setMediaCompare = function(value) {
        compare = value;
        compare.init('#compare');
    };

    var setMediaCompareAnalyze = function(value) {
        analyze = value;
        analyze.setErrorContainer('#error-container');
    };

    var addFiles = function(filesResult) {
        for (var filePos in filesResult) {
            var file = filesResult[filePos].data;
            files.push({data: file, fileId: filesResult[filePos].fileId});
        }
        refreshCompare();
    };

    var getFiles = function() {
        return files;
    };

    var fileInputBinding = function() {
        // File input
        $('#mediainfo-file-input').on('change', function() {
            var input = $(this)[0];
            if(input.files.length > 0) {
                var filesList = [];
                for (var i = 0, len = input.files.length; i < len; i++) {
                    if (list || filesList.length < 2 - countFiles()) {
                        filesList.push({file: input.files[i], fileId: fileId++});
                    }
                }

                if (filesList.length > 0) {
                    addSpinner();
                    analyze.getJsonFromFiles({files: filesList, callback: MediaCompareBase.addFiles});
                }

                displayNotMemberMessage(input.files.length);
            }
        });
    };

    var dragAndDropBinding = function() {
        $('.mediainfo-file-drop').on('dragover dragenter', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '3px dashed #0070bb');
        });

        $('.mediainfo-file-drop').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '3px dashed #e7e7e7');
        });

        $('.mediainfo-file-drop').on('drop', function(e) {
            var dt = e.originalEvent.dataTransfer;
            if (dt) {
                e.preventDefault();
                e.stopPropagation();

                var filesList = [];
                if (dt.items && dt.items.length > 0) {
                    for (var filePos in dt.items) {
                        if (dt.items[filePos].kind === 'file' && isItemIsFile(dt.items[filePos])) {
                            if (list || filesList.length < 2 - countFiles()) {
                                filesList.push({file: dt.items[filePos].getAsFile(), fileId: fileId++});
                            }
                        }
                    }

                    displayNotMemberMessage(dt.items.length);
                }
                else if(dt.files && dt.files.length > 0) {
                    for (var filePos in dt.files) {
                        if (!list && filesList.length < 2 - countFiles()) {
                            filesList.push({file: dt.files[filePos], fileId: fileId++});
                        }
                    }

                    displayNotMemberMessage(dt.files.length);
                }

                if (filesList.length > 0) {
                    addSpinner();
                    analyze.getJsonFromFiles({files: filesList, callback: MediaCompareBase.addFiles});
                }

                $('.mediainfo-file-drop').css('border', '3px dashed #01d318');
            }
            else {
                $(this).css('border', '3px dashed #e7e7e7');
            }
        });
    };

    var isItemIsFile = function(item) {
        if (item.webkitGetAsEntry) {
            var entry = item.webkitGetAsEntry();
            return entry.isFile;
        } else if (item.getAsEntry) {
            var entry = item.getAsEntry();
            return entry.isFile;
        }

        return true;
    };

    // Count files array (works after delete item)
    var countFiles = function() {
        var count = 0;
        for (var item in files) {
            if (undefined !== files[item]) {
                count++;
            }
        }

        return count;
    };

    var removeFileBinding = function() {
        // Remove file
        $('.remove-file').on('click', function() {
            var id = $(this).data('file-id');
            delete files[id];
            $(this).parent().remove();
            refreshCompare();

            // Hidde table when no files
            if ($('#compare > tbody > tr:first > td').length == 0) {
                $('#compare').addClass('hidden');
            }
        });
    };

    var displayChangeBinding = function() {
        $('input[name="compare-filter"][value="all"]').prop('checked', true);
        $('input[name="compare-filter"]').on('change', function() {
            applyDisplayFilter();
        });
    };

    var applyDisplayFilter = function() {
        // Reset filter
        $('#compare > tbody > tr.hidden').each(function() {
            $(this).removeClass('hidden');
        });

        // Apply filter only with 2 or more files selected
        if ($('#compare > tbody > tr:first > td').length < 2) {
            return;
        }

        switch ($('input[name="compare-filter"]:checked').val()) {
            case 'diff':
                $('#compare > tbody > tr.match').each(function() {
                    $(this).addClass('hidden');
                });
                break;
            case 'match':
                $('#compare > tbody > tr.danger').each(function() {
                    $(this).addClass('hidden');
                });
                break;
        }
    };

    var showDisplayFilter = function() {
        if ($('#compare > tbody > tr:first > td').length < 2) {
            $('#compare-filter-buttons').addClass('hidden');
        } else {
            $('#compare-filter-buttons').removeClass('hidden');
        }
    };

    var addSpinner = function() {
        $('#compare').addClass('hidden');
        $('#compare-loading').removeClass('hidden');
    };

    var removeSpinner = function() {
        $('#compare-loading').addClass('hidden');
        $('#compare').removeClass('hidden');
    };

    var refreshCompare = function() {
        compare.resetFiles();
        compare.addFiles(files);
        removeSpinner();
        compare.compareAndDisplay(removeFileBinding);
        showDisplayFilter();
        applyDisplayFilter();
    };

    var displayNotMemberMessage = function(filesAdded) {
        if (!list && filesAdded + countFiles() > 2 && $('#alert-not-member').length == 0) {
            $('#error-container').append(
                '<div id="alert-not-member" class="alert alert-info alert-dismissible" role="alert">\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                  '+$('#not-member').html()+'\
                </div>');
        }    };

    return {
        init: init,
        setList: setList,
        setMediaCompare: setMediaCompare,
        setMediaCompareAnalyze: setMediaCompareAnalyze,
        getFiles: getFiles,
        addFiles: addFiles,
        removeFileBinding: removeFileBinding,
    };
})();
