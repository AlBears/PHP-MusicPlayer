$(document).ready(function () {

    currentPlaylist = $('.info').data('ids');
    audioElement = new Audio();
    setTrack(currentPlaylist[0].id, currentPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function (e) {
        e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function () {
        mouseDown = true;
    });

    $(".playbackBar .progressBar").mousemove(function (e) {
        if (mouseDown == true) {
            timeFromOffset(e, this);
        }
    });

    $(".playbackBar .progressBar").mouseup(function (e) {
        timeFromOffset(e, this);
    });

    $(".volumeBar .progressBar").mousedown(function () {
        mouseDown = true;
    });

    $(".volumeBar .progressBar").mousemove(function (e) {
        if (mouseDown == true) {
            var percentage = e.offsetX / $(this).width();

            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }

        }
    });

    $(".volumeBar .progressBar").mouseup(function (e) {
        var percentage = e.offsetX / $(this).width();

        if (percentage >= 0 && percentage <= 1) {
            audioElement.audio.volume = percentage;
        }
    });

    $(document).mouseup(function () {
        mouseDown = false;
    })

});

function timeFromOffset(mouse, progressBar) {
    var percentage, seconds;
    percentage = mouse.offsetX / $(progressBar).width() * 100;
    seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
}

function prevSong() {
    if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
        audioElement.setTime(0);
    } else {
        currentIndex = currentIndex - 1;
        setTrack(currentPlaylist[currentIndex].id, currentPlaylist, true);
    }
}

function nextSong() {
    if (repeat == true) {
        audioElement.setTime(0);
        playSong();
        return;
    }
    if(currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0
    } else {
        currentIndex++;
    }

    var trackToPlay = currentPlaylist[currentIndex].id;
    setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "/img/icons/" + imageName);
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "/img/icons/" + imageName);
}

function setTrack(trackId, newPlaylist, play) {

    Array.prototype.indexOfObject = function (object) {
        for (var i = 0; i < this.length; i++) {
            if (JSON.stringify(this[i]) === JSON.stringify(object))
                return i;
        }
    }
    currentIndex = currentPlaylist.indexOfObject({
        id: trackId
    });

    pauseSong();

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

    if (audioElement.audio.currentTime == 0) {
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