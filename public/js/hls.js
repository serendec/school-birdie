function initHls(videoSrc) {
    const video = document.getElementById("video-player");

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
