$(document).ready(function () {

    currentPlaylist = $('.info').data('ids');
    audioElement = new Audio();
    setTrack(currentPlaylist[0].id, currentPlaylist, false);

    $(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
    });

    $(".playbackBar .progressBar").mousemove(function(e) {
        if (mouseDown == true) {
            timeFromOffset(e, this);
        }
    });

    $(".playbackBar .progressBar").mouseup(function(e) {
        timeFromOffset(e, this);
    });

    $(document).mouseup(function() {
        mouseDown = false;
    })

});

function timeFromOffset(mouse, progressBar) {
    var percentage, seconds;
        percentage = mouse.offsetX / $(progressBar).width() * 100;
        seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
}

function setTrack(trackId, newPlaylist, play) {

    $.post('/ajax/findSong', {
        songId: trackId
    }, function (data) {

        var track = JSON.parse(data);
        $('.trackName span').text(track.title);
        console.log(track);

        $.post('/ajax/findArtist', {
            artistId: track.artist
        }, function (data) {

            var artist = JSON.parse(data);
            $('.artistName span').text(artist.name);
        });

        $.post('/ajax/findAlbum', {
            albumId: track.album
        }, function (data) {

            var album = JSON.parse(data);
            $('.albumLink img').attr("src", album.artworkPath);
        });

        audioElement.setTrack(track);
        playSong();

    });

    if (play) {
        audioElement.play();
    }

}

function playSong() {

    if(audioElement.audio.currentTime == 0) {
        $.post('/ajax/updateCount', {
            songId: audioElement.currentlyPlaying.id 
        });
    } 
    
    $('.controlButton.play').hide();
    $('.controlButton.pause').show();
    audioElement.play();
}

function pauseSong() {
    $('.controlButton.pause').hide();
    $('.controlButton.play').show();
    audioElement.pause();
}