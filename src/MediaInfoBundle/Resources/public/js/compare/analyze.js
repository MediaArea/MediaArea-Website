var MediaCompareAnalyze = (function () {
    var MediaInfoModule,
        MI,
        filename,
        errorContainer,
        processing = false,
        CHUNK_SIZE = 1024 * 1024,
        multiFiles,
        multiCallback
        multiResult = [];

    // Initialize emscripten module
    var init = function(memFile, callback) {
        var locateFile = function() {
          return memFile;
        };

        MediaInfoModule = MediaInfoLib({'locateFile': locateFile, 'postRun': function() {
            if (typeof Promise !== 'undefined' && MediaInfoModule instanceof Promise) {
                MediaInfoModule.then(function(module) {
                    MediaInfoModule = module;
                    callback();
                });
            }
            else {
                callback();
            }
            return;
        }});
    };

    var setErrorContainer = function(value) {
        errorContainer = $(value);
    };

    // Process file
    var processFile = function(file, callback, fileId) {
        // Analyze file
        if (processing) {
            finish();
        }

        try {
            parseFile(file, callback, fileId);
        } catch (e) {
            displayError('Your browser is not compatible.');
        }
    };

    // Process multiple files
    var getJsonFromFiles = function(conf) {
        if (undefined !== conf.files && undefined !== conf.callback) {
            multiResult.length = 0;
        }

        if (undefined !== conf.files) {
            multiFiles = conf.files;
        }

        if (undefined !== conf.callback) {
            multiCallback = conf.callback;
        }

        if (undefined !== conf.fileId) {
            MI.Option('Inform', 'Text');
            multiResult.push({data: convertTextToJson(MI.Inform()), fileId: conf.fileId});
        }

        if (multiFiles.length > 0) {
            var file = multiFiles.shift();
            processFile(file.file, getJsonFromFiles, file.fileId);
        } else {
            multiCallback(multiResult);
        }
    };

    var convertTextToJson = function(text) {
        var json = {media: {track: []}},
            lines = text.split('\n'),
            track = 0;

        for (var i = 0, len = lines.length; i < len; i++) {
            var line = lines[i];
            var lineColonIndex = line.indexOf(':');
            if (lineColonIndex === -1) {
                if (line.trim() !== '') {
                    if (line.indexOf('#') === -1) {
                        track = json.media.track.push({'@type': line});
                        track--;
                    } else {
                        var val = line.split('#');
                        var trackName = val[0].trim();
                        var trackOrder = val[1].trim();

                        track = json.media.track.push({'@type': trackName, '@typeorder': trackOrder});
                        track--;
                    }
                }
            } else {
                var fieldName = line.substring(0, lineColonIndex - 1).trim();
                var fieldValue = line.substring(lineColonIndex + 1).trim();

                if (json.media.track[track]['@type'] == 'General' && (fieldName == 'Complete name' || fieldName == 'CompleteName')) {
                    json.media['@ref'] = fieldValue;
                } else {
                    json.media.track[track][fieldName] = fieldValue;
                }
            }
        }

        return json;
    };

    // Analyze file
    var parseFile = function(file, callback, fileId) {
        if (processing) {
            return;
        }
        processing = true;
        filename = file.name;

        var offset = 0;

        // Initialise MediaInfo
        MI = new MediaInfoModule.MediaInfo();

        MI.Option('File_FileName', file.name);
        MI.Open_Buffer_Init(file.size, 0);

        var loop = function(length) {
            if (processing) {
                var r = new FileReader();
                var blob = file.slice(offset, offset + length);
                r.onload = processChunk;
                r.readAsArrayBuffer(blob);
            } else {
                finish()
            }
        };

        var processChunk = function(e) {
            if (e.target.error === null) {
                // Send the buffer to MediaInfo
                try {
                    var state = MI.Open_Buffer_Continue(e.target.result);

                } catch(e) {
                    finish();
                    displayError('An error happened reading your file "'+filename+'".');
                    return;
                }

                //Test if there is a MediaInfo request to go elsewhere
                var seekTo = MI.Open_Buffer_Continue_Goto_Get();
                if(seekTo === -1) {
                    offset += e.target.result.byteLength;
                } else {
                    offset = seekTo;
                    MI.Open_Buffer_Init(file.size, seekTo); // Inform MediaInfo we have seek
                }
            } else {
                finish();
                displayError('An error happened reading your file "'+filename+'".');
                return;
            }

            // Bit 3 set means finalized
            if (state&0x08 || e.target.result.byteLength < 1) {
                MI.Open_Buffer_Finalize();
                callback({fileId: fileId});
                return;
            }

            loop(CHUNK_SIZE);
        };

        // Start
        loop(CHUNK_SIZE);
    };

    var finish = function() {
        MI.Close();
        MI.delete;
        processing = false;
    };

    // Display error message
    var displayError = function(error) {
        errorContainer.append(
'<div class="alert alert-danger alert-dismissible" role="alert">\
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
  '+error+'\
</div>');
    };

    // Get field name for display
    var fieldDisplayName = function(stream, streamId, field) {
        try {
            var streamMI;
            switch (stream) {
                case 'General':
                    streamMI = MediaInfoModule.Stream.General;
                    break;
                case 'Video':
                    streamMI = MediaInfoModule.Stream.Video;
                    break;
                case 'Audio':
                    streamMI = MediaInfoModule.Stream.Audio;
                    break;
                case 'Text':
                    streamMI = MediaInfoModule.Stream.Text;
                    break;
                case 'Menu':
                    streamMI = MediaInfoModule.Stream.Menu;
                    break;
                case 'Image':
                    streamMI = MediaInfoModule.Stream.Image;
                    break;
                case 'Other':
                    streamMI = MediaInfoModule.Stream.Other;
                    break;
                default:
                    return false;
            }

            return MI.Get(streamMI, streamId, field, MediaInfoModule.Info.Name_Text);
        } catch(e) {
            return false;
        }
    };

    return {
        init: init,
        setErrorContainer: setErrorContainer,
        getJsonFromFiles: getJsonFromFiles,
        fieldDisplayName: fieldDisplayName,
    };
});
