@extends('layout')

@section('body')
<div class="main-body">
    <div class="wallet" style="height:590px;">
        <div class="wa_phone" >
            <div class="wa_phone_body wa_phone_long">
                <div id="wa_myCarousel"  class="wa_phoneimg_body carousel slide">
                    <div class="carousel-inner">
                    @if ($lang == 'zh-cn')
                        <div class="item active">
                            <img src="../../images/app/pc/app1-30-clip1@2x.png" width="339px">
                        </div>
                        <div class="item">
                            <img src="../../images/app/pc/app1-30-clip2@2x.png" width="339px">
                        </div>
                        <div class="item">
                            <img src="../../images/app/pc/app1-30-clip3@2x.png" width="339px">
                        </div>
                        <div class="item">
                            <img src="../../images/app/pc/app1-30-clip4@2x.png" width="339px">
                        </div>
                        <div class="item">
                            <img src="../../images/app/pc/app1-30-clip5@2x.png" width="339px">
                        </div>
                    @else
                         <div class="item active">
                             <img src="../../images/app/pc/app1-30-clip1-en@2x.png" width="339px">
                         </div>
                         <div class="item">
                             <img src="../../images/app/pc/app1-30-clip2-en@2x.png" width="339px">
                         </div>
                         <div class="item">
                             <img src="../../images/app/pc/app1-30-clip3-en@2x.png" width="339px">
                         </div>
                         <div class="item">
                             <img src="../../images/app/pc/app1-30-clip4-en@2x.png" width="339px">
                         </div>
                         <div class="item">
                             <img src="../../images/app/pc/app1-30-clip5-en@2x.png" width="339px">
                         </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="wa_content" style="padding-left:6px;">
            <div class="wa_app1" >BTC.COM App</div>
            <div class="wa_app_mark_01">{{ trans('global.page.applications.shows-the-price-of-bitcoin') }}</div>
            <div class="wa_app_mark_02">{{ trans('global.page.applications.put-all-your-imagination') }}</div>
            <div class="wa_two_01">
                <img src="../../images/app/pc/qr-code@2x.png" width="128px">
            </div>
            <div class="wa_table_01">
                <table class="wa_table">
                    <tr>
                        <td>{{ trans('global.page.applications.current-version') }}:</td>
                        <td class="ex_table_td2">1.30</td>
                    </tr>
                    <tr>
                        <td>{{ trans('global.page.applications.updated') }}:</td>
                        <td class="ex_table_td2">{{ trans('global.page.applications.updated-app') }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('global.page.applications.environment') }}:</td>
                        <td class="ex_table_td2">{{ trans('global.page.applications.environment-app') }}</td>
                    </tr>
                </table>
            </div>
            <div class="wa_lookinfo_app" style=" padding-top: 25px">
                <a style=" float:left;" href="https://itunes.apple.com/app/apple-store/id1071486157?pt=117887436&ct=btc_com_page&mt=8" ><button class="wa_btn_look wa_btn_look_app wa wa_ios">{{ trans('global.page.applications.download') }}</button></a>
                @if (\App::getLocale() == 'zh-cn')
                    <a style=" float:left; margin-left: 25px;" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.bitmain.btccom" ><button class="wa_btn_look wa_btn_look_app wa_android">{{ trans('global.page.applications.download') }}</button></a>
                @else
                    <a style=" float:left; margin-left: 25px;" href="https://play.google.com/store/apps/details?id=com.bitmain.btccom" ><button class="wa_btn_look wa_btn_look_app wa_android">{{ trans('global.page.applications.download') }}</button></a>
                @endif
            </div>
            <div class="wa_viewcode">{{ trans('global.page.applications.scan-QR-code-to-download') }}</div>
        </div>
    </div>
</div>
@endsection
@section("script_resource_inline")@parent<script>$("#wa_myCarousel").carousel({ interval: 2200});</script>@endsection
