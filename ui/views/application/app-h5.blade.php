@extends('mobile.layout')

@section('body')
<div class="btc_app">
    <div class="btc_title">BTC.COM App</div>
    <div class="btc_title_small" style="margin-top: 10px;">{{ trans('global.page.applications.mobile-app-1') }}</div>
    <div class="btc_title_small">{{ trans('global.page.applications.mobile-app-2') }}</div>
    <table class="btc_app_table">
        <tr>
            <td>{{ trans('global.page.applications.current-version') }}</td>
            <td>1.30</td>
        </tr>
        <tr>
            <td>{{ trans('global.page.applications.updated') }}</td>
            <td>{{ trans('global.page.applications.updated-app') }}</td>
        </tr>
        <tr>
            <td>{{ trans('global.page.applications.environment') }}</td>
            <td>{{ trans('global.page.applications.environment-app') }}</td>
        </tr>
    </table>
    <a class="btn_link" style=" width:240px;" href="{{ route('application.download') }}"><button class="btc_btn_look" style="background-color: #4A90E2; margin-top:20px; width:242px;">{{ trans('global.page.applications.download') }}</button></a>
    <div class="btc_do">{{ trans('global.page.applications.you-can-also') }}</div>
    <div class="btc_app_content" data-toggle="modal" data-target="#myModal">
        <a class="btc_app_left"><img src="../../images/app/h5/icon-qr@2x.png" width="64px"/></a>
        <div class="btc_app_right">
            <span class="btc_app_p">{{ trans('global.page.applications.tap-QR-code-1') }}</span>
            <span class="btc_app_p">{{ trans('global.page.applications.tap-QR-code-2') }}</span>
        </div>
    </div>
    <div class="btc_app_content" >
        <a class="btc_app_left"><img src="../../images/app/h5/icon-share@2x.png" width="64px"/></a>
        <div class="btc_app_right">
            <span class="btc_app_share">{{ trans('global.page.applications.share-this-page-1') }}</span>
            <span class="btc_app_share">{{ trans('global.page.applications.share-this-page-2') }}</span>
        </div>
    </div>
    <div style="height:50px"></div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:70px;">
            <div class="modal-content model-code">
                <button type="button" class="close close_code" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="code_title">BTC.COM App</div>
                <a class="btc_code_img"><img src="../../images/app/h5/icon-qr@2x.png" width="128px"/></a>
                <div class="btc_code_mark">{{ trans('global.page.applications.scan-QR-code-to-download') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
@script('/node_modules/jquery/dist/jquery.js')
@script('/node_modules/bootstrap/dist/js/bootstrap.js')