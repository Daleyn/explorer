@extends('layout')

@section('style_resource_inline')@parent
<style>
    .text-muted {
        color: #AAA;
    }
</style>
@endsection

@section('script_resource_prepend')@parent
<script>
    var globals = {
        balance_dist: {!! json_encode($balance_dist) !!},
        count_list: {!! json_encode($count_list) !!},
        sum_list: {!! json_encode($sum_list) !!},
        count_percent: {!! json_encode($count_percent) !!},
        sum_percent: {!! json_encode($sum_percent) !!}
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
                    <li> {{ trans('global.page.stats-rich-list.title') }} </li>
                </ol>
            </div>

            <div class="row diff">

                <div class="row diff-chart">
                    <div class="col-xs-12 diff-chart-1 text-center">
                        <div id="richListCount" style="width: 1000px;height:300px; margin:0 auto;"></div>
                        <div class="diff-chart-title" style="color:#262626; font-size: 16px;margin-top:-25px;"> {{ trans('global.page.stats-rich-list.address-distribution') }} </div>
                    </div>
                </div>

                <div class="row diff-chart">
                    <div class="col-xs-12 diff-chart-1 text-center">
                        <div id="richListSum" style="width: 1000px;height:300px;margin:0 auto;"></div>
                        <div class="diff-chart-title"style="color:#262626; font-size: 16px;margin-top:-25px;"> {{ trans('global.page.stats-rich-list.balance-distribution') }} </div>
                    </div>
                </div>

                @inlinescript
                <script>
                    var richListCount = echarts.init(document.getElementById('richListCount'));
                    var richListSum = echarts.init(document.getElementById('richListSum'));

                    // 指定图表的配置项和数据
                    var option1= {
                        tooltip : {
                            trigger: 'axis',
                            formatter: '<table style="text-align: right">' +
                                '<tr><td colspan="3" style="text-align: center">{b0}</td></tr>' +
                                '<tr><td>{a0}&nbsp;:&nbsp;</td><td style="text-align: left"> {c0}</td></tr>' +
                                '<tr><td>{a1}&nbsp;:&nbsp;</td><td style="text-align: left"> {c1} %</td></tr></table>'
                        },
                        toolbox: {
                            show : false
                        },
                        calculable : true,
                        legend: {
                            data:['',''],
                        },
                        xAxis : {
                                type : 'category',
                                data : globals.balance_dist,
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel:{
                                    textStyle:{
                                        color:'#AAA',
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
                                        color: '#DDD',
                                        width: 1,
                                    }
                                }
                                
                            },
                        yAxis : [
                            {
                                type : 'value',
                                name : '{{ trans('global.common.count') }}',
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel : {
                                    formatter: '{value}',
                                    textStyle:{
                                        color:'#AAA',
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
                                        color: '#DDD',
                                        width: 1,

                                    }
                                }

                            },
                            {
                                type : 'value',
                                name : '{{ trans('global.common.percent') }}',
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel : {
                                    formatter: '{value} %',
                                    textStyle:{
                                        color:'#AAA',
                                        fontSize:'12px',
                                    }
                                },
                                splitLine:{
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#DDD',
                                        width: 1,
                                        type:'dashed',
                                    }
                                }
                            }
                        ],
                        series : [{
                                name:'{{ trans('global.common.count') }}',
                                type:'bar',
                                data:globals.count_list,
                                itemStyle:{
                                    normal:{
                                        color:'#529BD7'
                                    },

                                }
                            },
                            {
                                name:'{{ trans('global.common.percent') }}',
                                type:'line',
                                yAxisIndex: 1,
                                data:globals.count_percent,
                                itemStyle:{
                                    normal:{
                                        color:'#7799bb',
                                        lineStyle: {
                                            color: '#AAA',
                                            width: 2
                                        },
                                    }

                                }
                            }
                        ]
                    };


                    var option2= {
                        tooltip : {
                            trigger: 'axis',
                            formatter: '<table style="text-align: right">' +
                            '<tr><td colspan="3" style="text-align: center">{b0}</td></tr>' +
                            '<tr><td>{a0}&nbsp;:&nbsp;</td><td style="text-align: left"> {c0}</td></tr>' +
                            '<tr><td>{a1}&nbsp;:&nbsp;</td><td style="text-align: left"> {c1} %</td></tr></table>'
                        },
                        toolbox: {
                            show : false
                        },
                        calculable : true,
                        legend: {
                            data:['','']
                        },
                        xAxis : [
                            {
                                type : 'category',
                                data : globals.balance_dist,
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel:{
                                    textStyle:{
                                        color:'#AAA',
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
                                        color: '#DDD',
                                        width: 1,
                                    }
                                }

                            }
                        ],
                        yAxis : [
                            {
                                type : 'value',
                                name : 'BTC',
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel : {
                                    formatter: '{value}',
                                    textStyle:{
                                        color:'#AAA',
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
                                        color: '#DDD',
                                        width: 1,

                                    }
                                }

                            },
                            {
                                type : 'value',
                                name : '{{ trans('global.common.percent') }}',
                                axisLine: {            // 坐标轴线
                                    show: true,        // 默认显示，属性show控制显示与否
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#AAA',
                                        width: 1,
                                    }
                                },
                                axisLabel : {
                                    formatter: '{value} %',
                                    textStyle:{
                                        color:'#AAA',
                                        fontSize:'12px',
                                    }
                                },
                                splitLine:{
                                    lineStyle: {       // 属性lineStyle控制线条样式
                                        color: '#DDD',
                                        width: 1,
                                        type:'dashed',
                                    }
                                }
                            }
                        ],
                        series : [
                            {
                                name:'BTC',
                                type:'bar',
                                data:globals.sum_list,
                                itemStyle:{
                                    normal:{
                                        color:'#529BD7'
                                    },

                                }
                            },
                            {
                                name:'{{ trans('global.common.percent') }}',
                                type:'line',
                                yAxisIndex: 1,
                                data:globals.sum_percent,
                                itemStyle:{
                                    normal:{
                                        color:'#7799bb',
                                        lineStyle: {
                                            color: '#AAA',
                                            width: 2
                                        },
                                    }

                                }
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    richListCount.setOption(option1);
                    richListSum.setOption(option2);

                </script>
                @endinlinescript

                <div class="diff-history">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th style="text-align: center">{{ trans('global.common.address') }}</th>
                            <th>{{ trans('global.common.balance') }}</th>
                            <th>{{ trans('global.common.last-30-days-tx') }}</th>
                            <th>{{ trans('global.common.first-tx-time') }}</th>
                            <th>{{ trans('global.common.last-tx-time') }}</th>
                        </tr>

                        @foreach($rich_list as $k => $v)
                        <tr>
                            <td style="color:#AAA">{{ $k + 1 }}</td>
                            <td style="text-align: center!important">
                                <span class="txio-address">
                                    <a target="_blank" href="{{ route('search.general', ['q' => json_decode($v, true)['address']]) }}">
                                        {{ json_decode($v, true)['address'] }}
                                    </a>
                                </span>
                            </td>
                            <td>
                                {!! btc_format(json_decode($v, true)['balance'], false, true, false, 8) !!}
                            </td>
                            <td>{{ json_decode($v, true)['past_tx_count'] }}</td>
                            <td>{{ date('Y-m-d H:i:s', json_decode($v, true)['first_tx_timestamp']) }}</td>
                            @if (json_decode($v, true)['last_tx_timestamp'] != 0)
                                <td>{{ date('Y-m-d H:i:s', json_decode($v, true)['last_tx_timestamp']) }}</td>
                            @else
                                <td>{{ date('Y-m-d H:i:s') }}</td>
                            @endif
                        </tr>
                        @endforeach

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection