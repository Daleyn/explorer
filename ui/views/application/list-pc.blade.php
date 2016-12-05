@extends('layout')

@section('body')
<div class="list-body">


    <div class="vote-location">
        <div class="vote-location-left">
            <p class="vote-location-title">{{ trans('global.page.applications.vote-title') }}</p>
            <p class="vote-location-mark">{{ trans('global.page.applications.vote-detail') }}</p>
            <p class="vote-location-look"> <a href="{{ route('subject.list') }}" target="_blank"><button class="wa_btn_look">{{ trans('global.page.applications.vote-list-button') }}</button></a></p>
            <p class="vote-location-create"> <a href="{{ route('subject.create') }}" target="_blank"><button class="wa_btn_look">{{ trans('global.page.applications.vote-create-button') }}</button></a></p>
        </div>
        <div class="vote-location-right">
             <div class="vote-enter-pic"></div>
        </div>
    </div>

    <div class="wallet">
        <div class="wa_phone">
            <div class="wa_phone_body">
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
        <div class="wa_content">
            <div class="wa_app">BTC.COM App</div>
            <div class="wa_app_mark">{{ trans('global.page.applications.shows-the-price-of-bitcoin') }}</div>
            <div class="wa_app_mark1">{{ trans('global.page.applications.put-all-your-imagination') }}</div>
            <div class="wa_two">
                <img src="../../images/app/pc/qr-code@2x.png" width="128px">
                <div class="wa_code_text">{{ trans('global.page.applications.scan-QR-code') }}</div>
            </div>
            <div class="wa_lookinfo">
                <a href="{{ route('application.app') }}" target="_blank"><button class="wa_btn_look wa_btn_look_app">{{ trans('global.page.applications.view-details') }}</button></a>
            </div>
        </div>
    </div>
    <div class="extension" style="margin-top:20px;">
        <a class="Ex_link" href="{{ route('application.extension') }}">
            <div class="Ex_title">{{ trans('global.page.applications.extension-for-chrome') }}</div>
            <div class="Ex_small-title">{{ trans('global.page.applications.download-it-now') }}</div>
            <div class="Ex_img">
                <div class="Ex_img_element"><span class="Ex_img1"></span></div>
                <div class="Ex_img_element"><span class="Ex_img2"></span></div>
                <div class="Ex_img_element"><span class="Ex_img3"></span></div>
            </div>
            <div class="Ex_img">
                <div class="Ex_content_element"><span class="Ex_content">{{ trans('global.page.applications.viewing-details-of-blocks') }}</span></div>
                <div class="Ex_content_element"><span class="Ex_content">{{ trans('global.page.applications.real-time-price') }}</span></div>
                <div class="Ex_content_element"><span class="Ex_content">{{ trans('global.page.applications.global-market-price') }}</span></div>
            </div>
            <div class="Ex_download">
                <a class="go_chrome" href="https://chrome.google.com/webstore/detail/btccom-extension-for-chro/bbliigjegnkdnolaabpfdoimdmncjdca"  target="_blank">
                    <button class="Ex_btn_download">
                        <div class="Ex_btn_panel">
                            <span class="Ex_chrome_logo"></span>
                            <span class="Ex_dwonload_text">{{ trans('global.page.applications.chrome-webstore') }}</span>
                        </div>
                    </button>
                </a>
                <div class="Ex_pointer_div"><a  href="http://static.btc.com/chrome-ext%2FBTC.COM-Extension-for-Chrome_v1.1.0.crx" class="Ex_pointer" download>{{ trans('global.page.applications.click-here-to-install') }}</a></div>
            </div>
        </a>
    </div>
</div>

@endsection
@section("script_resource_inline")@parent<script>$("#wa_myCarousel").carousel({ interval: 2200});</script>@endsection
