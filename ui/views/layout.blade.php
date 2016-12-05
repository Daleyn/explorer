<!doctype html>
<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="{{ trans('global.meta.keyword') }}">
    <meta name="author" content="BTC.COM">
    <meta name="format-detection" content="telephone=no" />

    <title>{{ $title }}{{ env('IS_TESTNET3') ? ' - Testnet' : '' }} - BTC.com</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="BTC.com">
    <link rel="shortcut icon" href="/images/favicon.ico">

    @style('/style/bootstrap.less')
    @style('/style/main.less')

    @script('/node_modules/jquery/dist/jquery.js')
    @script('/node_modules/jquery-placeholder/jquery.placeholder.js')
    @script('/node_modules/bootstrap/dist/js/bootstrap.js')
    @script('/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')
    @script('/node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js')
    @script('/node_modules/cookies-js/dist/cookies.js')
    @script('/node_modules/micro-template/lib/micro-template.js')
    @script('/node_modules/moment/moment.js')
    @script('/node_modules/d3/d3.js')
    @script('/node_modules/vue/dist/vue.js')
    @script('/node_modules/big.js/big.js')
    @script('/node_modules/lodash/index.js')
    @script('/node_modules/twbs-pagination/jquery.twbsPagination.js')
    @script('/lib/daterangepicker.js')
    @script('/lib/jquery.scrollUp.js')
    @script('/lib/js.cookie.js')
    @inlinescript
    <script>
        $(function () {
            $.scrollUp({
                scrollDistance: 1000,
                scrollText: '↑ {{ trans('global.common.scroll_to_top') }}'
            });

            $('input, textarea').placeholder({customClass:'my-placeholder'});
        });
    </script>
    @endinlinescript
    @script('/node_modules/highcharts-release/highcharts.js')
    @script('/node_modules/echarts/dist/echarts.js')
    @script('/node_modules/socket.io-client/socket.io.js')

    @yield('style_resource')
    @yield('style_resource_inline')

    <!-- VERSION -->
@if (\App::getLocale() == 'zh-cn')
    <!-- 比特大陆招聘 Web 前端工程师：http://redirect.bitmain.com/career/fe -->
@endif
{{-- 需要前置的 JS 资源，多用于输出页面脚本配置 --}}
@yield('script_resource_prepend')
</head>
<body>

@include('reject_ie8')

@include('include.header')

@yield('body')

@include('include.footer')

@yield('template')
@yield('script_resource')
@yield('script_resource_inline')
@include('ga')
@inlinescript
<script src="https://s.btc.com/common/js/selfxss/0.0.1/selfxss.min.js"></script>
@endinlinescript
</body>
</html>
