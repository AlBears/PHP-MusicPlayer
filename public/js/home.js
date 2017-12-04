$(document).ready(function () {

    currentPlaylist = $('.info').data('ids');
    audioElement = new Audio();
    setTrack(currentPlaylist[0].id, currentPlaylist, false);

});

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
    console.log(audioElement);
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