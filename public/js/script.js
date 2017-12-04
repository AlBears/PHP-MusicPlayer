var currentPlaylist = [],
    audioElement;

function formatTime(seconds) {
    var time, minutes, seconds, extraZero;
        time = Math.round(seconds);
        minutes = Math.floor(time/60);
        seconds = time - (minutes*60);

        extraZero = (seconds < 10) ? "0" : "";
 
        return minutes + ":" + extraZero + seconds;
}


function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay", function(){
        $(".progressTime.remaining").text(formatTime(this.duration));
    });

    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }
}