$(document).ready(function () {

    currentPlaylist = $('.info').data('ids');
    audioElement = new Audio();
    setTrack(currentPlaylist[0], currentPlaylist, false);

});

function setTrack(trackId, newPlaylist, play) {
    audioElement.setTrack("/music/bensound-goinghigher.mp3");

    if (play) {
        audioElement.play();
    }

}

function playSong() {
    $('.controlButton.play').hide();
    $('.controlButton.pause').show();
    audioElement.play();
}

function pauseSong() {
    $('.controlButton.pause').hide();
    $('.controlButton.play').show();
    audioElement.pause();
}