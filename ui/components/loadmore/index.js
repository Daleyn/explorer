$(function() {
    var $moreBtn = $('.page-navMore');
    var $container = $moreBtn.parent();
    var $appendTo = $($moreBtn.data('append'));

    if (!$moreBtn.length) return;

    var page = +$moreBtn.data('page');
    var pagesize = +$moreBtn.data('pagesize');
    var total = +$moreBtn.data('total');

    $moreBtn.click(function() {
        $container.hide();
        page++;
        $.get('?page=' + page)
            .then(function(html) {
                $appendTo.append(html);

                var rest = total - page * pagesize;
                if (rest > 0) {
                    $moreBtn.find('span').text(rest);
                    $container.show();
                }
            });
    });
});