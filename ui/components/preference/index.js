(function() {
    var tpl = template('preference');

    var $el = $('.preference [data-toggle="popover"]').popover({
        html: true,
        content: function() {
            return tpl(Store.preference());
        }
    });

    $el.on('inserted.bs.popover', function() {
        var $this = $(this);
        var id = $this.attr('aria-describedby');

        $('#' + id).find('input').each(function(i, input) {
            $(input).on('change', function() {
                $el.trigger('setoption', [$(this).data('key'), this.checked]);
            });
        });
    });

    $el.on('setoption', function setStorage ($e, k, v) {
        var opt = {};
        opt[k] = +v;
        Store.preference(opt);
    });
})();
