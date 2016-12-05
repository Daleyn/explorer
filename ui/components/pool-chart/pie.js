(function() {
    var data = globals.pools.filter(function(el) {
        return el.id != 0;
    }).slice(0, 9);

    var othersPercent = 1 - data.reduce(function(prev, cur) {
            return prev + Number(cur.p);
        }, 0);

    data.push({
        n: 0,
        p: othersPercent,
        name: 'Others',
        id: -1,
        link: '#'
    });

    //var innerData = [{name: 'BIP 101', p: 0.4}, {name: 'BIP 100', p: 0.3}, {name: 'None', p: 0.3}];

    var width = globals.chartWidth, height = globals.chartHeight;
    var outerRadius = height / 2 - 20,
        innerRadius = height / 2 - 60;

    var outerArc = d3.svg.arc()
        .innerRadius(outerRadius - 25)
        .outerRadius(outerRadius);

    var innerArc = d3.svg.arc()
        .innerRadius(innerRadius - 25)
        .outerRadius(innerRadius);

    var pie = d3.layout.pie()
        .value(function(o) {
            return o.p;
        })
        .sort(null)
        .padAngle(0.0125);

    var outerColor = ['#864ac0', '#e674e6', '#ff6666', '#ffcc66', '#fff1b9', '#b5ffba', '#00cd79', '#66ffff', '#66ccff', '#0080ff'];
    var innerColor = ['#eee', '#ccc', '#aaa', '#888', '#666'];

    var svg = d3.select(".pool-panel-share-chart-inner")
        .append("svg")
        .attr("width", width)
        .attr("height", height);

    svg.append('g')
        .attr('transform', "translate(" + width / 2 + "," + height / 2 + ")")
        .selectAll("path")
        .data(pie(data))
        .enter().append("path")
        .style("fill", function(d, i) {
            return outerColor[i];
        })
        .attr("d", outerArc)
        .style('cursor', 'pointer')
        .on('mouseenter', function(d, i) {
            d3.select(this).transition().style('transform', 'scale(1.03)');
            d3.select('tr[data-pool-id="' + d.data.id + '"').classed('active', true);
        })
        .on('mouseleave', function(d, i) {
            d3.select(this).transition().style('transform', 'scale(1)');
            d3.select('tr[data-pool-id="' + d.data.id + '"').classed('active', false);
        })
        .each(function(d, i) {
            $(this).tooltip({
                html: true,
                title: '#' + (i + 1) + ' ' + d.data.name + '<br>' + (d.data.p * 100).toFixed(2) + '%',
                container: 'body',
                animation: false
            });
        });

    svg.append('g')
        .attr('transform', "translate(" + width / 2 + "," + height / 2 + ")")
        .selectAll("path")
        .data(pie(globals.bipData))
        .enter().append("path")
        .style("fill", function(d, i) {
            return innerColor[i];
        })
        .attr("d", innerArc)
        .style('cursor', 'pointer')
        .on('mouseenter', function(d, i) {
            d3.select(this).transition().style('transform', 'scale(1.03)');
        })
        .on('mouseleave', function(d, i) {
            d3.select(this).transition().style('transform', 'scale(1)');
        })
        .each(function(d, i) {
            $(this).tooltip({
                html: true,
                title: '#' + (i + 1) + ' ' + d.data.name + '<br>' + (d.data.p * 100).toFixed(2) + '%',
                container: 'body',
                animation: false
            });
        });
})();