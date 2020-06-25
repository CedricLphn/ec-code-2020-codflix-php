/**
 * MODAL
 */
$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
})


/**
 * YOUTUBE INTEGRATION
 */

// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;

let regex = /(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/;


let youtubeId = videoId.match(regex)[1];

function onYouTubeIframeAPIReady() {
    player = new YT.Player('movie', {
        videoId: youtubeId,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.seekTo(currentTime);
    event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
let sendCurrentTime = false;


var update = setInterval(updateTimestamp, 5000);
function onPlayerStateChange(event) {
    // USER ENDED VIDEO
    if (event.data == YT.PlayerState.ENDED) {
        console.log("end");
        $.post("/api/?action=history&query=update_timestamp", {
            mediaId: mediaId,
            serieId: serieId,
            currentTime : 0,
            action: 'done'
        });

        sendCurrentTime = false;
        clearInterval(update);

    }else if (event.data == YT.PlayerState.PLAYING) {
        sendCurrentTime = true;

    }else if (event.data == YT.PlayerState.PAUSED) {
        updateTimestamp();
        sendCurrentTime = false;

    }

    
    
}

function updateTimestamp() {
    if(!sendCurrentTime)
        return;

    $.post("/api/?action=history&query=update_timestamp", {
        mediaId: mediaId,
        serieId: serieId,
        currentTime: Math.round(player.getCurrentTime()),
        action: 'setTime'
    });

    //if (event.data == YT.PlayerState.PLAYING && !done) {
    //setTimeout(stopVideo, 6000);
    //done = true;
    //}
}