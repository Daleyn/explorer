@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        day_data: {!! json_encode($day_stats) !!},
        month_data: {!! json_encode($month_stats) !!}
    };

</script>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('stats') }}">{{ trans('global.menu.stats') }}</a></li>
                    <li> {{ trans('global.page.stats-block-size.title') }} </li>
                </ol>
            </div>

            <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
            <div class="row">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title"> {{ trans('global.page.stats-block-size.latest-90days') }}</div>
                    </div>
                    <div class="tb"><div id="dayStats4" class="tbstats"></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.median-daily-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-Bytes') }}</span></div>
                    </div>
                    <div class="tb"><div id="dayStats1" class="tbstats"></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.average-daily-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-Bytes') }}</span></div>
                    </div>
                    <div class="tb"><div id="dayStats2" class="tbstats"></div><div class="tbtip" style="width:115px;">
                            {{ trans('global.page.stats-block-size.number-of-daily-transactions') }}</div>
                    </div>
                    <div class="tb"><div id="dayStats3" class="tbstats"></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.sum-of-daily-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-MB') }}</span></div>
                    </div>
                    <div  style="height:50px;"></div>
                </div>
            </div>


            @inlinescript
            <script type="text/javascript">
                // 数值三分位
                function numberFormat(number, decimals, decPoint, thousandsSep) {
                    decimals = isNaN(decimals) ? 2 : Math.abs(decimals);
                    decPoint = (decPoint === undefined) ? '.' : decPoint;
                    thousandsSep = (thousandsSep === undefined) ? ',' : thousandsSep;

                    var sign = number < 0 ? '-' : '';
                    number = Math.abs(+number || 0);

                    var intPart = parseInt(number.toFixed(decimals), 10) + '';
                    var j = intPart.length > 3 ? intPart.length % 3 : 0;

                    return sign + (j ? intPart.substr(0, j) + thousandsSep : '') + intPart.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousandsSep) + (decimals ? decPoint + Math.abs(number - intPart).toFixed(decimals).slice(2) : '');
                }

                // 基于准备好的dom，初始化echarts实例
                var dayStats1 = echarts.init(document.getElementById('dayStats1'));
                var dayStats2 = echarts.init(document.getElementById('dayStats2'));
                var dayStats3 = echarts.init(document.getElementById('dayStats3'));
                var dayStats4 = echarts.init(document.getElementById('dayStats4'));

                // 指定图表的配置项和数据
                var option1 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.day_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                   
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.average-daily-block-size') }}',
                        type: 'line',
                        data: globals.day_data['avg_size'],
                        itemStyle:{
                            normal:{
                                color:'#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                },
                            },

                        }
                    }],
                };


                var option2 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.day_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            },
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.number-of-daily-transactions') }}',
                        type: 'line',
                        data: globals.day_data['tx_count'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };


                var option3 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.day_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.sum-of-daily-block-size') }}',
                        type: 'line',
                        data: globals.day_data['size_count'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };


                var option4 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.day_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.median-daily-block-size') }}',
                        type: 'line',
                        data: globals.day_data['median_block_size'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };

                // 使用刚指定的配置项和数据显示图表。
                dayStats1.setOption(option1);
                dayStats2.setOption(option2);
                dayStats3.setOption(option3);
                dayStats4.setOption(option4);

                echarts.connect([dayStats1, dayStats2, dayStats3, dayStats4]);
            </script>
            @endinlinescript


            <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
            <div class="row">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title"> {{ trans('global.page.stats-block-size.all-history') }}</div>
                    </div>
                    <div class="tb"> <div id="monthStats4" class="tbstats"></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.median-monthly-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-Bytes') }}</span></div>
                    </div>
                    <div class="tb"><div id="monthStats1" class="tbstats" ></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.average-monthly-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-Bytes') }}</span></div>
                    </div>
                    <div class="tb"><div id="monthStats2" class="tbstats"></div><div class="tbtip" style="width:115px;">
                            {{ trans('global.page.stats-block-size.number-of-monthly-transactions') }}</div>
                    </div>
                    <div class="tb"> <div id="monthStats3" class="tbstats"></div><div class="tbtip">
                            {{ trans('global.page.stats-block-size.sum-of-monthly-block-size') }}
                            <span class="tipspan">{{ trans('global.page.stats-block-size.unit-MB') }}</span></div>
                    </div>
                    <div  style="height:50px;"></div>
                </div>
            </div>

            @inlinescript
            <script type="text/javascript">
                // 基于准备好的dom，初始化echarts实例
                var monthStats1 = echarts.init(document.getElementById('monthStats1'));
                var monthStats2 = echarts.init(document.getElementById('monthStats2'));
                var monthStats3 = echarts.init(document.getElementById('monthStats3'));
                var monthStats4 = echarts.init(document.getElementById('monthStats4'));

                // 指定图表的配置项和数据
                var option1 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.month_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.average-monthly-block-size') }}',
                        type: 'line',
                        data: globals.month_data['avg_size'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };


                var option2 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.month_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.number-of-monthly-transactions') }}',
                        type: 'line',
                        data: globals.month_data['tx_count'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };


                var option3 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.month_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.sum-of-monthly-block-size') }}',
                        type: 'line',
                        data: globals.month_data['size_count'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };


                var option4 = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            var tipText = '<table class="text-sans-serif"><tr><td>' + params[0].name + '</td></tr>' +
                                    '<tr><td>' + params[0].seriesName + ':&nbsp;</td><td>' + numberFormat(params[0].value, 0) + '</td></tr>' +
                                    '</table>';
                            return tipText;
                        }
                    },
                    grid: {
                        y: 20,
                        x2: 0,
                        y2: 20
                    },
                    xAxis: {
                        data: globals.month_data['date'],
                        axisLine: {            // 坐标轴线
                            show: true,        // 默认显示，属性show控制显示与否
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    yAxis: {
                        axisLine: {            // 坐标轴线
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#AAAAAA',
                                width: 1,
                            }
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#888888',
                                fontSize:'12px',
                            }
                        },
                        axisTick:{
                            show: true,
                            lineStyle: {
                                color: '#DDDDDD',
                                width: 1,
                            }
                        },
                        splitLine:{
                            lineStyle: {       // 属性lineStyle控制线条样式
                                color: '#DDDDDD',
                                width: 1,
                            }
                        }
                    },
                    series: [{
                        name: '{{ trans('global.page.stats-block-size.median-monthly-block-size') }}',
                        type: 'line',
                        data: globals.month_data['median_block_size'],
                        itemStyle:{
                            normal:{
                                color: '#7799bb',
                                lineStyle:{
                                    color:'#7799bb',
                                    width:2
                                }
                            }
                        }
                    }]
                };

                // 使用刚指定的配置项和数据显示图表。
                monthStats1.setOption(option1);
                monthStats2.setOption(option2);
                monthStats3.setOption(option3);
                monthStats4.setOption(option4);

                echarts.connect([monthStats1, monthStats2, monthStats3, monthStats4]);
            </script>
            @endinlinescript
        </div>
    </div>
@endsection
