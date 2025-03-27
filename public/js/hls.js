function initHls(videoSrc) {
    const video = document.getElementById("video-player");
    const playBtn = document.getElementById("playBtn");

    playBtn.addEventListener("click", () => {
        video.play();
        playBtn.style.display = "none";
    });

    video.addEventListener("seeking", function (event) {
        if (video.currentTime > video.played.end(0)) {
            video.currentTime = video.played.end(0);
        }
    });

    video.addEventListener("contextmenu", (event) => event.preventDefault());

    if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(videoSrc);
        hls.attachMedia(video);
    } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
        video.src = videoSrc;
    } else {
        alert("動画再生に対応していないブラウザです。\nお手数でございますが、別のブラウザをご利用ください。");
    }
}
