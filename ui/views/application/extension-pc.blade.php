@extends('layout')

@section('body')
<div class="list-body">

    <div class="extension" style="height:730px;">
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
            <div class="ex_down">
                <div class="ex_version">
                   <table class="ex_table">
                       <tr>
                           <td class="ex_table_td1">{{ trans('global.page.applications.current-version') }}:</td>
                           <td class="ex_table_td2">1.1.0</td>
                       </tr>
                       <tr>
                           <td class="ex_table_td1">{{ trans('global.page.applications.updated') }}:</td>
                           <td class="ex_table_td2">{{ trans('global.page.applications.updated-extension') }}</td>
                       </tr>
                       <tr>
                           <td class="ex_table_td1">{{ trans('global.page.applications.application-size') }}:</td>
                           <td class="ex_table_td2">1.2 MB</td>
                       </tr>
                       <tr>
                           <td class="ex_table_td1">{{ trans('global.page.applications.environment') }}:</td>
                           <td class="ex_table_td2">{{ trans('global.page.applications.environment-extension') }}</td>
                       </tr>
                   </table>
                </div>
                <div class="ex_btn_down">
                    <a class="go_chrome_ex" href="https://chrome.google.com/webstore/detail/btccom-extension-for-chro/bbliigjegnkdnolaabpfdoimdmncjdca"target="_blank">
                        <button class="Ex_btn_download">
                            <div class="Ex_btn_panel">
                                <span class="Ex_chrome_logo"></span>
                                <span class="Ex_dwonload_text">{{ trans('global.page.applications.chrome-webstore') }}</span>
                            </div>
                        </button>
                    </a>
                    <div class="Ex_pointer_div ex_point_div" >
                        <a href="http://static.btc.com/chrome-ext%2FBTC.COM-Extension-for-Chrome_v1.1.0.crx" class="Ex_pointer" download>{{ trans('global.page.applications.click-here-to-install') }}</a>
                    </div>
                </div>

            </div>
    </div>
</div>
@endsection
@section("script_resource_inline")@parent<script>$("#wa_myCarousel").carousel({ interval: 2200});</script>@endsection
