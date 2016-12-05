/**
 * svg
 * @export Chart.cal.render(data)
 */

(window.Chart || (window.Chart = {})).cal = {
    inst: null,

    clear: function() {
        if (!this.inst) return false;

        this.rect.each(function() {
            $(this).tooltip('destroy');
        });

        this.sample.selectAll('.q-sample').each(function() {
            $(this).tooltip('destroy');
        });

        this.inst.remove();
        this.inst = null;
    },
    render: function(rawData, startDate, endDate) {
        if (this.inst) {
            this.clear();
        }

        var width = 1140,
            height = 205,
            cellSize = 18,
            padding = 2;

        var calData = [];
        for (var w = [], i = 0, start = moment.utc(startDate, 'YYYYMMDD'), end = moment.utc(endDate, 'YYYYMMDD');
             end.diff(start, 'days') >= 0;
             i++, start.add(1, 'days')) {
            var date = moment.utc(start);
            w.push({
                date: date,
                value: rawData[date.format('YYYYMMDD')]
            });

            if (i == 6) {
                calData.push(w);
                w = [];
                i = -1;
            }
        }

        //console.log('cal array', calData);

        var max = d3.max(Object.keys(rawData), function(k) { return rawData[k] }) || 1;

        function color(v) {
            if (v == null) return 'q';
            v = Math.floor(Number(v));
            if (v == 0) return 'q0';

            var p = Math.ceil(v / max * 100);

            return 'q' + Math.ceil(p / 10);
        }


        var svg = d3.select('.cal-svg').append("svg")
            .attr("width", width)
            .attr("height", height);

        this.inst = svg;

        // 右上角示例
        this.sample = svg.append('g')
            .attr('transform', "translate(" + (width - cellSize * 10 - 96) + ", 0)");

        this.sample.selectAll('rect')
            .data(d3.range(11).map(function(i) { return 'q' + i; }))
            .enter()
            .append('rect')
            .attr('class', function(d) {
                return 'q-sample ' + d;
            })
            .attr({
                'width': cellSize,
                'height': cellSize,
                'x': function(d, i) { return i * (cellSize + padding); }
            })
            .each(function (d) {
                var text;
                var level = d.slice(1);
                if (level == 10) {
                    text = '100%'
                } else if (level > 0) {
                    text = '≤' + level * 10 + '%';
                } else {
                    text = '0';
                }
                $(this).tooltip({
                    title: text,
                    container: document.body
                });
            });

        this.sample.append('text').text(globals.trans.cal.less).attr('class', 'cal-day-sample').attr('x', -5).attr('y', 14).attr('text-anchor', 'end');
        this.sample.append('text').text(globals.trans.cal.more).attr('class', 'cal-day-sample').attr('x', 11 * (cellSize + padding) + 3).attr('y', 14);

        // 月份
        var monthData = [];
        for (var li = 0, i = 1, last = calData[0][calData[0].length - 1], cur, ii = calData.length; i < ii; i++) {
            cur = calData[i][calData[i].length - 1];

            if (cur.date.month() != last.date.month() || i + 1 == ii) {

                if (i + 1 == ii) i = ii;

                monthData.push({
                    date: last.date,
                    width: (i - li) * (cellSize + padding) - padding,
                    left: li * (cellSize + padding)
                });

                last = cur;
                li = i;
            }
        }

        //console.log('monthData', monthData);

        var monthRect = svg.append('g')
            .attr('transform', 'translate(43, 30)')
            .selectAll('cal-month-cell')
            .data(monthData)
            .enter()
            .append('g')
            .attr('transform', function(d) {
                return 'translate(' + d.left  + ', 0)';
            });

        monthRect.append('rect')
            .attr({
                width: function (d) {
                    return d.width;
                },
                height: 30,
                'class': 'cal-month-cell'
            });

        monthRect.append('text')
            .attr({
                'transform': function(d) {
                    return 'translate(' + (d.width) / 2 + ', 20)';
                },
                'text-anchor': 'middle',
                'class': 'cal-month-cell-text'
            })
            .text(function(d) {
                return d.date.format('YYYY/MM');
            });

        // 日期格子
        var calGrid = svg
            .append("g")
            .attr("transform", "translate(43, 65)");

        calGrid.selectAll('text')
            .data([globals.trans.cal.sunday, globals.trans.cal.wednesday, globals.trans.cal.saturday])
            .enter()
            .append('text')
            .attr('transform', function(d, i) {
                return 'translate(-10, ' + ((cellSize + padding) * i * 3 + 14)  + ')';
            })
            .classed('cal-day-note', true)
            .text(function(d) {return d})
            .attr('text-anchor', 'end');

        this.rectGroup = calGrid.selectAll('g')
            .data(calData)
            .enter().append('g')
            .attr('transform', function(d, i) {
                return 'translate(' + i * (cellSize + padding) + ', 0)'
            });

        this.rect = this.rectGroup.selectAll('.cal-day-cell')
            .data(function(d) { return d; })
            .enter()
            .append('rect')
            .attr({
                width: 0,
                height: 0,
                x: 0,
                y: function(d, i) {
                    return d.date.day() * (cellSize + padding)
                },
                'class': function(d) {
                    return 'cal-day-cell ' + color(d.value);
                }
            });

        this.rect.transition()
            .duration(500)
            .delay(200)
            .attr({
                width: cellSize,
                height: cellSize
            })
            .each(function(d) {
                $(this).tooltip({
                    title: d.date.format('YYYY/MM/DD') + ' : ' + (d.value == null ? 'N/A' : d.value),
                    container: 'body',
                    animation: false
                });
            });
    },

    renderMonth: function(monthData, loadCallback) {
        //prepare data
        var start = moment.utc(monthData.start, 'YYYYMMDD');
        var end = moment.utc(monthData.end, 'YYYYMMDD');
        var $tpl = $(template(__inline('/components/pool-chart/cal.html'))({
            start: moment(start),
            end: moment(end),
            data: monthData.data
        }));

        $tpl.find('.cal-month-bar-entity').each(function(i, el) {
            var $el = $(el);
            var key = String($el.data('key'));
            //console.log(key);
            $el.tooltip({
                container: 'body',
                animation: false,
                title: key.slice(0, -4) + '/' + key.slice(4, -2)  + ' : ' + monthData.data[key].n
            });
        });

        var totalWidth = Object.keys(monthData.data).length * 20 + $tpl.find('.cal-month-bar-yearGroup').length * 2;
        var visibleWidth = 1060;

        var listContainer = $tpl.find('.cal-month-bar-ul');

        if (visibleWidth >= totalWidth) {
            $tpl.filter('.cal-month-nav').hide();
        } else {
            $tpl.filter('.cal-month-nav').on('click', function() {
                var $this = $(this);
                var left = parseInt(listContainer.css('transform').split(',')[4], 10);
                if (isNaN(left)) {
                    left = 0;
                }
                var validLeft, nextLeft, exceed;
                if ($this.hasClass('cal-month-nav-left')) {    // left
                    nextLeft = left + 20 * 36;
                    validLeft = 0;
                    exceed = nextLeft >= validLeft;
                    listContainer.css('transform', 'translateX(' + +(exceed ? validLeft : nextLeft) + 'px)');
                } else {        // right
                    nextLeft = left - 20 * 36;
                    validLeft = visibleWidth - totalWidth;
                    exceed = nextLeft <= validLeft;
                    listContainer.css('transform', 'translateX(' + +(exceed ? validLeft : nextLeft) + 'px)');
                }
                $this.toggleClass('disabled', exceed);
                $this.siblings('.cal-month-nav').removeClass('disabled');
            });

            setTimeout(function() {
                listContainer.css('transform', 'translateX(' + +(visibleWidth - totalWidth) + 'px)');
                $tpl.filter('.cal-month-nav-right').addClass('disabled');
            }, 1000);
        }

        $tpl.on('click', '.cal-month-bar-entity', function() {
            loadCallback('' + $(this).data('key'));
        });

        $('.cal-month-bar').html($tpl);
    },

    calDate: function (start) {
        if (start == null) start = moment.utc();
        var end, now = moment.utc().startOf('month');
        start = moment.utc(start).startOf('month');
        end = moment(start).add(1, 'years').startOf('month').subtract(1, 'days');

        if (end.diff(now) > 0) {      // 超出结束时间
            end = now;
            start = moment(end).subtract(11, 'months');
        }

        // adjust days to sunday or saturday
        start.subtract(start.day(), 'days');
        end.endOf('month').add(6 - end.day(), 'days');

        return [start, end];
    },

    loadAddressData: function(start, end, address) {
        return $.getJSON('/service/addressTxCountPerDay?start=' + start + '&end=' + end + '&address_id=' + address)
            .then(function(data) {
                Chart.cal.render(data.data, data.start, data.end);
            });
    },

    loadPoolData: function(start, end, pool) {
        return $.getJSON('/service/poolBlockCounterPerDay?start=' + start + '&end=' + end + '&pool=' + pool)
            .then(function(data) {
                Chart.cal.render(data.data, data.start, data.end);
            });
    },

    init: function(type) {
        var date;
        switch (type) {
            case 'address':
                Chart.cal.renderMonth(globals.monthData, function(key) {
                    var date = this.calDate(moment.utc(key, 'YYYYMMDD')).map(function(el) { return el.format('YYYYMMDD') });
                    this.loadAddressData(date[0], date[1], globals.address_id);
                }.bind(this));

                date = this.calDate().map(function(el) { return el.format('YYYYMMDD') });
                this.loadAddressData(date[0], date[1], globals.address_id);
                break;
            case 'pool':
                Chart.cal.renderMonth(globals.monthData, function(key) {
                    var date = this.calDate(moment.utc(key, 'YYYYMMDD')).map(function(el) { return el.format('YYYYMMDD') });
                    this.loadPoolData(date[0], date[1], globals.pool);
                }.bind(this));

                date = this.calDate().map(function(el) { return el.format('YYYYMMDD') });
                this.loadPoolData(date[0], date[1], globals.pool);
                break;
            default:
                //pass
        }
    }
};