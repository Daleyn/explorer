$(function() {
    var obtn = document.getElementById('back-top-btn');

    if (!obtn) return;

    var clientHeight = document.documentElement.clientHeight;

    window.onscroll = function() {
        var osTop = document.documentElement.scrollTop || document.body.scrollTop;
        if (osTop >= clientHeight) {
            obtn.style.display = 'block';
        } else {
            obtn.style.display = 'none';
        }

    };

    obtn.onclick = function() {
        document.documentElement.scrollTop = document.body.scrollTop = 0;
    }
});