$(function() {
    // 获取锚点, 每秒闪烁一次, 闪烁5秒
    var blinkAnchor = window.location.hash;
    var blinkPoint = setInterval( function() { $(blinkAnchor).fadeOut(100).fadeIn(900); }, 1000);
    setInterval( function() { clearInterval(blinkPoint); }, 5000);
});