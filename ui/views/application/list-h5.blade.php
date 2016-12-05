@extends('mobile.layout')

@section('body')
<div class="btc_app">
    <div class="btc_title">BTC.COM App</div>
    <div class="btc_title_small" style="margin-top: 10px;">{{ trans('global.page.applications.mobile-app-1') }}</div>
    <div class="btc_title_small">{{ trans('global.page.applications.mobile-app-2') }}</div>
    <div id="wa_myCarousel" class="carousel slide" style="margin-top:20px;">
        <div class="carousel-inner btc_app_info">
            <div class="item btc_img1 active"></div>
            <div class="item btc_img2"></div>
            <div class="item btc_img3"></div>
            <div class="item btc_img4"></div>
            <div class="btc_app_look">
                <a class="btn_link" href="{{ route('application.app') }}"><button class="btc_btn_look">{{ trans('global.page.applications.view') }}</button></a>
                <a class="btn_link" href="{{ route('application.download') }}"><button class="btc_btn_look" style="background-color: #4A90E2; margin-top:20px;">{{ trans('global.page.applications.download') }}</button></a>
            </div>
        </div>
    </div>
</div>
<div class="btc_extension">
    <div class="btc_title" style="padding-top:17px; height: inherit;">{{ trans('global.page.applications.extension-for-chrome') }}</div>
    <div class="btc_title_small" style="margin-top: 10px;">{{ trans('global.page.applications.mobile-extension-1') }}</div>
    <div class="btc_ex_img1"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.viewing-details-of-blocks') }}</div>
    <div class="btc_ex_img2＋"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.real-time-price') }}</div>
    <a  class="btn_link" href="{{ route('application.extension') }}" style="margin-top:22px;"><button class="btc_btn_look">{{ trans('global.page.applications.view') }}</button></a>
</div>
@endsection
@script('/node_modules/jquery/dist/jquery.js')
@script('/node_modules/bootstrap/dist/js/bootstrap.js')
@section("script_resource_inline")@parent<script>$("#wa_myCarousel").carousel({ interval: 2200});</script>@endsection
