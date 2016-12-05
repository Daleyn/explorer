@extends('layout')

@script('/components/utils/qrcode.min.js')

@section('style_resource_inline')@parent
<style>
    .addr_tx_subscribe {
        display: block; float: right; font-size: 14px;
    }

    .subscribe_email_input {
        background:#ffffff; border:1px solid #e6e9ee; width:245px; height:28px; margin-bottom: 8px;
    }
    .subscribe_email_button {
        color: #FFFFFF; border-radius: 6px; padding: 5px 23px 5px 23px; float: right;
    }
    .panel-heading-title{
        height:20px;
    }
    .address-nav{
        height: 40px;
        margin-left:-60px;
        border:solid 0px red;
        border:0px;
    }
    .address-nav>li{
        height: 40px;
        list-style: none;
        margin-top: -10px;
    }
    .address-nav>li:first-child>a{
        margin-left: 0px;
    }
    .address-nav>li>a{
        color:#337ab7;
        display: block;
        border-radius: 5px 5px 0px 0px;
        cursor: pointer;
        background-color: #f5f5f5;
        margin-left: 1px;
        text-decoration: none;
        height: 40px;
        line-height: 23px;
        border:0px!important;
        padding:10px 45px;
        padding-right: 30px;
    }
    .address-nav>li>a:hover{
        opacity: 0.8;
    }
    .address-icon{
        border:solid 0px red;
        background-size:16px auto;
        background-position: left 20px center;
        background-repeat: no-repeat;
    }
    .address-exchange{
        background-image: url("/images/exchange.svg");
    }
    .address-link{
        background-image: url("/images/link.svg");
    }
    .address-chart{
        background-image: url("/images/chart.svg");
    }
    .nav-tabs > li.active > a:hover{
        opacity: 1;
    }
    .nav-tabs > li.active > a.address-exchange{
        background-image: url("/images/exchange2.svg");
    }

    .nav-tabs > li.active > a.address-link{
        background-image: url("/images/link2.svg");
    }
    .nav-tabs> li.active > a.address-chart{
        background-image: url("/images/chart2.svg");
    }

    .stats-range{
        padding-left: 6px;
        margin-left: 6px;
        width:165px;
    }
    .col-md-8 table{
        min-width:250px;
        border:solid 0px red;

    }
    .col-md-8 td{
        line-height: 30px;
    }
    .col-md-8 td:first-child{
        padding-left:0px!important;
        color:#888888;
    }
    .col-md-6 span:first-child{
        color:#888888;
    }
    #largest_tx_link{
        display: block;
        width:250px;
        overflow: hidden;
        text-overflow: ellipsis;

    }
    .addressArrow{
        width:18px;
        height:10px;
        border:solid 0px red;
        background-size:16px auto;
        background-position: center center;
        background-repeat: no-repeat;
        float: right;
        margin-right: 15px;
    }
    .leftArrow{
        background-image: url("/images/tx-arrow-left@2x.png");
    }
    .rightArrow{
        background-image: url("/images/tx-arrow-right@2x.png");
    }
    .doubleArrow{
        padding-left: 25px;
        height: 25px;
        line-height:25px;
        background-size:14px auto;
        background-position: left 6px center;
        background-repeat: no-repeat;
        border:solid 0px red;
        background-image: url("/images/tx-exchange@2x.png");
    }
    .mt-panel{
        height: 130px;
        width:100%;
        padding:25px;
        padding-left: 20px;
        border-bottom: 1px solid #eeeeee;
    }
    .mt-panel>div{
        height:26px;
        line-height: 26px;;
    }
    .mt-title{
        font-size: 16px;
        font-weight: 600;
    }
    .mt-sign{
        display: flex;
        justify-content: flex-start;
    }
    .mt-datetime{
        margin-left: 25px;
        line-height: 30px;
        color: #aaa;
    }
    .mt-sign>a{
        height: 30px;
        line-height: 30px;
        cursor: pointer;
        padding-left: 25px;
        padding-right: 10px;
        display: block;
        text-decoration: none;
        border:solid 0px red;
    }
    .mt-sign>a:first-child{
        margin-left: 0px;
        margin-right: 10px;
        background-image:url("/images/from.svg");
        background-size: 16px auto;
        background-repeat: no-repeat;
        background-position: left center;
    }
    .mt-sign>a:nth-child(2){
        margin-left: 20px;
        text-transform : uppercase;
        background-image:url("/images/author.svg");
        background-size: 16px auto;
        background-repeat: no-repeat;
        background-position: left center;
    }
    .mt-small-num{
        display: block;
        float: right;
        height: 21px;
        background-color: #f5f5f5;
        margin-top: 1px;
        margin-left: 7px;
        padding: 0 5px 0 5px;
        font-size: 12px;
        border-radius: 4px;
    }

</style>
@endsection

@section('script_resource_prepend')@parent
<script>
    var globals = {
        address: {!!  json_encode($addr['address']) !!},
        address_id: {!! json_encode($addr['address_id']) !!},
        upvote: {!! json_encode(isset($addrinfo) ? $addrinfo['upvote'] : 0) !!},
        downvote: {!! json_decode(isset($addrinfo) ? $addrinfo['downvote'] : 0) !!},
        voted: {!! json_encode($voted) !!},
        impressions: {!! json_encode($impressions) !!},
        monthData: {!! json_encode($monthData) !!},
        trans: {!! json_encode($trans) !!},
        trans_subscribe: {!! json_encode($trans_subscribe) !!},
        lang: {!! json_encode(\App::getLocale()) !!},
        page: {!! json_encode($page) !!},
        pagesize: {!! json_encode($pagesize) !!},
        page_count: {!! json_encode($page_count) !!},
    };
</script>
@endsection

@inlinescript
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>
@endinlinescript

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ trans('global.page.address.address') }} - {{ $addr['address'] }}
                        @if (isset($addrinfo) && !empty($addrinfo['owner_note']))
                            <span class="text-muted">{{ $addrinfo['owner_note'] }}</span>
                        @endif
                    </li>
                </ol>
            </div>

            <div class="row">
                <div class="panel panel-bm addressAbstract">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.common.summary') }}</div>
                    </div>
                    <div class="panel-body">
                        <div class="abstract-inner addressAbstract-inner">
                            <div class="abstract-section">
                                <dl style="margin-right: -30px;">
                                    <dt>{{ trans('global.common.address') }}</dt>
                                    <dd>
                                        {{ $addr['address'] }}
                                        <a href="javascript:" class="icon-address-qr" style="margin-left: 10px;"></a>
                                    </dd>
                                    @inlinescript
                                    <script>
                                        $(function() {
                                            $('.icon-address-qr').popover({
                                                container: 'body',
                                                content: '<div id="address_qr" style="width: 155px; height: 155px;"></div>',
                                                html: true,
                                                placement: 'bottom',
                                                trigger: 'hover',
                                                template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                                            });

                                            $('.icon-address-qr').on('shown.bs.popover', function () {
                                                new QRCode(document.getElementById('address_qr'), {
                                                    text: "bitcoin:{{ $addr['address'] }}",
                                                    width: 155,
                                                    height: 155,
                                                    colorDark : "#000000",
                                                    colorLight : "#ffffff",
                                                    correctLevel : QRCode.CorrectLevel.H
                                                });
                                            });
                                        });
                                    </script>
                                    @endinlinescript
                                </dl>
                                <dl>
                                    <dt>{{ trans('global.common.balance') }}</dt>
                                    <dd> {!! btc_format($addr['balance']) !!} </dd>
                                </dl>
                                @if (isset($addrinfo) && !empty($addrinfo['owner_note']))
                                <dl>
                                    <dt>{{ trans('global.common.owner_note') }}</dt>
                                    <dd> {{ $addrinfo['owner_note'] }} </dd>
                                </dl>
                                @endif
                            </div>
                            <div class="abstract-section">
                                <dl>
                                    <dt>{{ trans('global.common.totalReceived') }}</dt>
                                    <dd> {!! btc_format($addr['received']) !!} </dd>
                                </dl>
                                <dl>
                                    <dt>{{ trans('global.common.n_tx') }}</dt>
                                    <dd> {{ number_format($addr['tx_count']) }} </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                @if($addr['tx_count'] > 0)
                <div class="panel panel-bm">
                    <div class="panel-heading" style="background-color:#e6e9ee">
                        <div class="panel-heading-title">

                            <ul class="address-nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#transaction" class="address-icon address-exchange" aria-controls="transaction" role="tab" data-toggle="tab">
                                        {{ trans('global.page.address.Transaction') }}
                                        <span class="mt-small-num"> {{ number_format($addr['tx_count']) }} </span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#stats" class="address-icon address-chart" aria-controls="stats" role="tab" data-toggle="tab">
                                        {{ trans('global.page.address-tx-stats.stats') }}
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#link" class="address-icon address-link" aria-controls="link" role="tab" data-toggle="tab">
                                        {{ trans('global.page.address.Mentions') }}
                                        <span id="mentions_count" class="mt-small-num"></span>
                                    </a>
                                </li>
                            </ul>

                            <span class="text-right addr_tx_subscribe" id="subscribe">
                                {{--<a href="javascript:" id="subscribe_href">--}}
                                    {{--{{ trans('global.page.address-subscribe.subscribe-to-transaction') }}--}}
                                {{--</a>--}}
                                {{--<div class="addr-window">--}}
                                     {{--<div class="addr-icon-up"></div>--}}
                                     {{--<div class="addr-window-content">--}}

                                         {{--<input type="email" class="subscribe_email_input" placeholder="{{ trans('global.page.address-subscribe.placeholder') }}" id="subscribe_email"><br>--}}
                                         {{--<span style="visibility:hidden; color: #cc3300; line-height: 32px; float: left; display: block" id="invalid_subscribe_email">{{ trans('global.page.address-subscribe.invalid-email-address') }}</span>--}}
                                         {{--<button type="button" class="btn btn-primary subscribe_email_button" onclick="send_subscribe_email()">{{ trans('global.page.address-subscribe.submit') }}</button>--}}

                                     {{--</div>--}}
                                {{--</div>--}}
                            </span>
                        </div>
                    </div>
                    @inlinescript
                    <script>
                        $('#subscribe_href').click(function () {
                            if (globals.lang == 'zh-cn') {
                                $('.subscribe_email_input').css('width', '245');
                            } else if (globals.lang == 'ru') {
                                $('.subscribe_email_input').css('width', '250');
                            } else {
                                $('.subscribe_email_input').css('width', '240');
                            }
                            $(".addr-window").toggle();
                        });

                        function is_Email(email) {
                            var reg = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,10}){1,2})$/;
                            return reg.test(email);
                        }

                        function send_subscribe_email() {
                            var subscribe_email = $('#subscribe_email').val();
                            if (is_Email(subscribe_email)) {

                                $.ajax('/service/subscribe/address/' +  globals.address, {
                                    method: 'POST',
                                    data: {
                                        email: subscribe_email,
                                        subscribe_lang: globals.lang
                                    },
                                    headers: {
                                        'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
                                    },
                                    success: function (data) {
                                        if (data.error_no == 0) {
                                            $('#subscribe').popover('hide');
                                            show_subscribe_success();
                                        } else {
                                            alert(globals.trans_subscribe['parameter_is_not_valid']);
                                        }
                                    }
                                });

                            } else {
                                $('#invalid_subscribe_email').css('visibility', '');
                            }
                        }

                        function show_subscribe_success() {
                            if (globals.lang == 'en') {
                                $('.addr-window-content').css('height', '140px');
                            }
                            var url = __inline("/images/icon-submit-success@2x.png");
                            $('.addr-window-content').html('<p style="text-align: center;"><img src="' + url + '"' +
                            'style="align-content: center; width: 32px; height: 32px;"></p>' +
                            '<p style="text-align:left; color: #aaaaaa">' + globals.trans_subscribe['send-success']  + '</p>');
                        }

                    </script>
                    @endinlinescript
                    <div class="panel-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="transaction">
                                @include('block-show-tx-part', ['txList' => $addr['txs'], 'address' => $addr['address'], 'address_tags' => $address_tags])
                                <div class="page-nav">
                                    <ul id="page-pagination" class="pagination-sm"></ul>
                                </div>

                                @if($addr['tx_count'] - $page * $pagesize > 0)
                                    <div class="more-append"></div>
                                    <div class="page-nav">
                                        @inlinescript
                                            <script src="/components/loadmore/index.js?__inline"></script>
                                        @endinlinescript
                                        {{--<a href="javascript:" class="page-navMore" data-append=".more-append" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{ $addr['tx_count']  }}">{{ trans('global.common.load-more') }} (<span>{{ $addr['tx_count'] - $page * $pagesize }}</span> {{ trans_choice('global.common.load-more-left', number_format($addr['tx_count'] - $page * $pagesize)) }})</a>--}}
                                    </div>
                                @endif

                            </div>
                            <div role="tabpanel" class="tab-pane" id="stats">
                                <div class="cal">
                                    <div class="cal-svg"></div>
                                    <div class="cal-month-bar"></div>
                                </div>

                                @include('address-show-stats', ['address' => $addr['address']])
                            </div>
                            <div role="tabpanel" class="tab-pane" id="link" style="margin-top: -20px;margin-bottom: 20px;">
                                <div class="link-panel">

                                </div>
                                <div class="page-nav">
                                    <ul id="link-pagination" class="pagination-sm"></ul>
                                </div>
                            </div>

                        </div>

                        {{-- 日期选择器 --}}
                        @script('/components/pool-chart/cal.js')
                        @inlinescript
                        <script>
                            window.Chart.cal.init('address');
                        </script>
                        @endinlinescript

                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@inlinescript
<script src="/components/loadmore/index.js?__inline"></script>
<script>
    $(document).ready(function(){
//        getMentions(1);
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/service/addressMentions?address=" + globals.address + "&page=1", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var resp = JSON.parse(xhr.responseText).data;
                    $('#mentions_count').html(resp.mentions_count); // js 添加 mentions 数量
                    getMentionsPage(resp.mentions_page_count);
                    if (resp.mentions_count <= resp.mentions_page_size) {  // 如果 mentions 数量少于1页，则不显示分页器
                        $('#link-pagination').empty();
                    }
                }
            }
        };
        xhr.send()
    });

    $('#page-pagination').twbsPagination({
        totalPages: globals.page_count,
        visiblePages: 7,
        first: '<<',
        prev: '<',
        next: '>',
        last: '>>',
        href: '?page=@{{number}}' ,
        onPageClick: function (event, page) {
            $('#not-spa-demo-content').text('Page ' + page);
        }
    });

    function  getMentionsPage(mentions_pageCount){

        $('#link-pagination').twbsPagination({
            totalPages: mentions_pageCount,
            visiblePages: 7,
            first: '<<',
            prev: '<',
            next: '>',
            last: '>>',
            {{--href: '?page=@{{number}}' ,--}}
            onPageClick: function (event, page) {
                getMentions(page);
            }
        });

    }

   function getMentions(page){
       $(".link-panel").html("");
       var address=globals.address;
       var xhr = new XMLHttpRequest();
       xhr.open("GET", "/service/addressMentions?address=" + globals.address + "&page=" + page, true);
       xhr.onreadystatechange = function() {
           if (xhr.readyState == 4) {
               if (xhr.status >= 200 && xhr.status < 300) {
                   var resp = JSON.parse(xhr.responseText).data;
                   getMentionsPage(resp.mentions_page_count);
                   resp.mentions.forEach(function(symbol){
                      var html=`<div class="mt-panel">
                                      <div class="mt-title">
                                        <span style=" display:inline-block; width: 1000px; white-space:nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            ${symbol.title}
                                        </span>
                                      </div>
                                      <div class="mt-link"><a target="_blank" href="${symbol.link}">${symbol.link}</a></div>
                                      <div class="mt-sign">
                                          <a target="_blank" href="http://${symbol.site}">${symbol.site}</a>
                                          <a target="_blank" href="${symbol.author_link}">${symbol.author}</a>

                                          <span class="mt-datetime"> ${symbol.updated} </span>
                                      </div>
                                 </div>`
                       $(".link-panel").append(html);
                   })

               } else {

               }

           }
       }
       xhr.send();
   }

</script>
@endinlinescript