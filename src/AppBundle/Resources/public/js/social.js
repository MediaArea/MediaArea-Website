$(document).ready(function() {
    $(".share").socialSharePrivacy({
        language: document.documentElement.lang,
        uri: "https://mediaarea.net",
        services: {
            facebook: {
                action: "recommend",
                font: "verdana"
            },
            twitter: {
                text: "MediaInfo provides easy access to technical and tag information about video and audio files."
            },
            flattr: {
                uid: "MediaArea",
                uri: "https://mediaarea.net/MediaInfo"
            }
        }
    });
});
