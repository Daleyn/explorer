<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="apple-touch-icon" href="/mobile_images/icon-144.png">
    <meta name="format-detection" content="telephone=no" />

    <title>{{ $title }}{{ env('IS_TESTNET3') ? ' - Testnet' : '' }} - BTC.com</title>

    @style('/style/bootstrap.less')
    @style('/style/main_mobile.less')

    @script('/lib/zepto.js')
    @script('/components_mobile/scrolltop.js')

    @yield('style_resource')
    @yield('style_resource_inline')

    <!-- VERSION -->

    @yield('script_resource_prepend')
</head>