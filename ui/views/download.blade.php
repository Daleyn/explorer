@extends('layout')

@style('/wallet/style/wallet.css')

@section('body')

    <div class="main-body">
        <div class="container">
           <div class="wal_left">
                <div class="left_img"></div>
           </div>
           <div class="wal_right">
                <div class="wal_right_top">
                    <h1>{{ trans('global.page.wallet.heading') }}</h1>
                    <div class="thickline"></div>
                    <h2>{{ !$unavailable ? trans('global.page.wallet.desc') : trans('global.page.wallet.not_available_yet') }}</h2>

                </div>
                @if(!$unavailable)
                    <div class="wal_right_bottom">
                        @if($weixin)
                           <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.blocktrail.mywallet" class="phonebtn anzhuo">
                        @else
                           <a href="/download/android" class="phonebtn anzhuo">
                        @endif
                                 <span>{{ trans('global.page.wallet.android') }}</span>
                                 <span class="click-to-download">{{ trans('global.page.wallet.click-to-download') }}</span>
                           </a>
                           <a href="https://itunes.apple.com/us/app/blocktrail-bitcoin-wallet/id1019614423?mt=8" class="phonebtn ios">
                                 <span>{{ trans('global.page.wallet.ios') }}</span>
                                 <span class="click-to-download">{{ trans('global.page.wallet.click-to-download') }}</span>
                           </a>
                    </div>
                @endif
           </div>
        </div>
    </div>

    <div class="container">
        <div class="features-row">
            <div class="row">
                <div class="col-sm-4 col-xs-12 text-center">
                    <i class="glyphicon glyphicon-send"></i>
                    <h3></i> Send and Receive Bitcoin easily and securely</h3>
                </div>
                <div class="col-sm-4 col-xs-12 text-center">
                    <i class="glyphicon glyphicon-btc"></i>
                    <h3></i> Full control over your Bitcoin private keys</h3>
                </div>
                <div class="col-sm-4 col-xs-12 text-center">
                    <i class="glyphicon glyphicon-phone"></i>
                    <h3></i> Access your wallet on any device, at any time.</h3>
                </div>
            </div>
        </div>
    </div>

@endsection
