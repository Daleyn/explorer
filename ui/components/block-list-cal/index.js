(function() {
    var calContainer = $('.blockList-cal');

    var start = moment.unix(globals.startTimestamp).utcOffset(0),
    end = moment.unix(globals.endTimestamp).utcOffset(0),
    cur = moment.unix(Math.min(globals.endTimestamp, globals.currentTimestamp)).utcOffset(0);

    function year(y) {
        return template('block-list-cal-year', {
            startYear: start.year(),
            endYear: end.year(),
            currentYear: y
        });
    }

    function month(m) {
        return template('block-list-cal-month', {
            startMonth: memYear == start.year() ? start.month() : 0,
            endMonth: memYear == end.year() ? end.month() + 1 : 12,
            currentMonth: m
        });
    }

    function date(d) {
        return template('block-list-cal-day', {
            startDay: memYear == start.year() && memMonth == start.month() ? start.date() : 1,
            endDay: memYear == end.year() && memMonth == end.month() ? end.date() : moment([memYear, memMonth]).endOf('month').date(),
            currentDate: d,
            cur: cur
        });
    }

    var memYear = cur.year(), memMonth = cur.month(), memDay = cur.date();

    var html = $(template('block-list-cal', {
        year: year(cur.year()), month: month(cur.month()), date: date(cur.date())
    }));

    html.on('click', 'a', function() {
        var $this = $(this);
        var type = $this.data('type');
        switch (type) {
            case 'year':
                cur.year(memYear = $this.text());
                $this.siblings().removeClass('active').end().addClass('active');
                html.find('.blockList-cal-row-month').slideUp(200, function() {
                    $(month(-1)).hide().replaceAll($(this)).slideDown(200);
                });
                html.find('.blockList-cal-row-date').slideUp(200);
                break;
            case 'month':
                cur.month(memMonth = $this.text() - 1);
                $this.siblings().removeClass('active').end().addClass('active');
                html.find('.blockList-cal-row-date').slideUp(200, function() {
                    $(date(-1)).hide().replaceAll($(this)).slideDown(200);
                });
                break;
            case 'date':
                cur.date(memDay = $this.text());
                $this.siblings().removeClass('active').end().addClass('active');
                break;
        }
    });

    calContainer.html(html);
})();