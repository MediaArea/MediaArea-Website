var MediaCompare = (function () {
    var files = [],
        res = {fileIds: []},
        compareTable,
        analyze;

    var init = function(table) {
        compareTable = $(table);
    };

    var setMediaCompareAnalyze = function(value) {
        analyze = value;
    };

    var compareAndDisplay = function(callback) {
        compareTable.empty();
        compare();
        displayFilename();
        displayFields();
        callback();
    }

    var addFiles = function(filesToAdd) {
        for (var file in filesToAdd) {
            files.push(filesToAdd[file].data);
            res.fileIds.push(filesToAdd[file].fileId);
        }
    };

    var resetFiles = function() {
        files.length = 0;
        res = {fileIds: []};
    };

    var compare = function() {
        parseFilename();
        var trackList = getTrackList();
        for (var i = 0, len = trackList.length; i < len; i++) {
            var list = getFieldList(trackList[i].name, trackList[i].order);
            trackList[i].fields = list;
        }
        res.tracks = trackList;
    };

    var parseFilename = function() {
        var data = [];

        for (var i = 0, len = files.length; i < len; i++) {
            data.push(files[i].media['@ref']);
        }
        res.filename = data;
    };

    var getTrackList = function() {
        var trackType = ['General', 'Video', 'Audio', 'Text', 'Menu', 'Image', 'Other'],
            list = [];

        for (var i = 0, len = trackType.length; i < len; i++) {
            var trackCount = tracksCount(trackType[i]);
            if (trackCount == 1) {
                list.push({name: trackType[i]});
            } else if (trackCount > 1) {
                for (var j = 1; j <= trackCount; j++) {
                    list.push({name: trackType[i], order: j});
                }
            }
        }

       return list;
    };

    var tracksCount = function(trackType) {
        var trackCount = 0;

        var i = files.length;
        while (i--) {
            var j = files[i].media.track.length;
            while (j--) {
                var track = files[i].media.track[j];
                if (trackType == track['@type']) {
                    if (track.hasOwnProperty('@typeorder') && track['@typeorder'] > trackCount) {
                        trackCount = track['@typeorder'];
                    } else if (trackCount == 0) {
                        trackCount = 1;
                    }
                }
            }
        }

        return trackCount;
    };

    var getFieldList = function(trackType, trackOrder) {
        var list = [];

        for (var i = 0, len = files.length; i < len; i++) {
            var j = files[i].media.track.length;
            while (j--) {
                var track = files[i].media.track[j];
                if (trackType == track['@type']) {
                    if (undefined === trackOrder || trackOrder == 1) {
                        if (!track.hasOwnProperty('@typeorder') || (track.hasOwnProperty('@typeorder') && track['@typeorder'] == 1)) {
                            list = getFieldListFromTrack(track, list, i);
                        }
                    } else if (track.hasOwnProperty('@typeorder') && track['@typeorder'] == trackOrder) {
                        list = getFieldListFromTrack(track, list, i);
                    }
                }
            }
        }

        return list;
    };

    var getFieldListFromTrack = function(track, list, i) {
        for (var field in track) {
            if (field.substring(0, 1) != '@') {
                if (field == 'extra') {
                    for (var extraField in track[field]) {
                        if (undefined === list[extraField]) {
                            list[extraField] = [];
                        }

                        list[extraField][i] = track[field][extraField];
                    }
                } else {
                    if (undefined === list[field]) {
                        list[field] = [];
                    }

                    list[field][i] = track[field];
                }
            }
        }

        return list;
    };

    var displayFilename = function() {
        var row = '<th>Filename</th>';

        for (var i = 0, len = res.filename.length; i < len; i++) {
            row += '<td class="truncate-cell"><div title="'+res.filename[i]+'"><span><i data-file-id="'+res.fileIds[i]+'" class="glyphicon glyphicon-remove text-danger remove-file" title="Remove this file"></i>&nbsp;'+textUtils.sanitizeHtml(res.filename[i])+'</span></div></td>';
        }
        compareTable.append('<thead><tr class="table-header">'+row+'</tr></thead>');
    };

    var displayFields = function() {
        for (var i = 0, len = res.tracks.length; i < len; i++) {
            var track = res.tracks[i];
            var row = '<th>'+track.name+(track.hasOwnProperty('order') ? ' '+track.order : '')+'</th>';
            var j = files.length;
            while (j--) {
                row += '<td></td>';
            }
            compareTable.append('<tr class="old-files">'+row+'</tr>');
            for (var field in track.fields) {
                var row = '<th>'+textUtils.sanitizeHtml(field).trim()+'</th>',
                    prev,
                    diff = false;
                for (var j = 0, filesLen = files.length; j < filesLen; j++) {
                    var fieldValue = track.fields[field][j];
                    if (j == 0) {
                        prev = fieldValue;
                    } else if (diff === false && prev != fieldValue) {
                            diff = true;
                    }
                    if (undefined === fieldValue) {
                        row += '<td></td>';
                    } else {
                        row += '<th>'+textUtils.sanitizeHtml(fieldValue).trim()+'</th>';
                    }
                }
                compareTable.append('<tr class="'+(diff ? 'danger' : 'match')+'">'+row+'</tr>');
            }
        }
    };

    return {
        init: init,
        setMediaCompareAnalyze: setMediaCompareAnalyze,
        addFiles: addFiles,
        resetFiles: resetFiles,
        compareAndDisplay: compareAndDisplay,
    };
})();
