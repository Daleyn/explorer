@extends('mobile.layout')

@section('body')
<div class="btc_extension" style="margin-top: -20px">
    <div class="btc_title" style="padding-top:17px; height: inherit; margin-top: 20px">{{ trans('global.page.applications.extension-for-chrome') }}</div>
    <div class="btc_title_small" style="margin-top: 10px;">{{ trans('global.page.applications.mobile-extension-1') }}</div>
    <div class="btc_ex_img1"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.viewing-details-of-blocks') }}</div>
    <div class="btc_ex_img2"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.display-various') }}</div>
    <div class="btc_ex_img3"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.real-time-price') }}</div>
    <div class="btc_ex_img4"></div>
    <div class="btc_img1_text">{{ trans('global.page.applications.global-market-price') }}</div>
    <table class="btc_app_table">
        <tr>
            <td>{{ trans('global.page.applications.current-version') }}</td>
            <td>1.0.2</td>
        </tr>
        <tr>
            <td>{{ trans('global.page.applications.updated') }}</td>
            <td>{{ trans('global.page.applications.updated-extension') }}</td>
        </tr>
        <tr>
            <td>{{ trans('global.page.applications.application-size') }}</td>
            <td>285KB</td>
        </tr>
        <tr>
            <td>{{ trans('global.page.applications.environment') }}</td>
            <td>{{ trans('global.page.applications.environment-extension') }}</td>
        </tr>
    </table>
</div>
@endsection
