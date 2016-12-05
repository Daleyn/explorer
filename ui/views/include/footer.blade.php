<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="padding-left: 0;">
                <div class="copyright">
                    <div class="copyright-logo"></div>
                    <div class="copyright-text">&copy; Copyright BTC.COM 2016. All Rights Reserved.</div>
                </div>
            </div>
            <div class="col-xs-9 links" style="padding-right: 0;">
                <div class="links-column">
                    <div class="links-category">{{ trans('global.footer.Product') }}</div>
                    <ul class="links-list">
                        <li class="links-list-item"><a target="_blank" href="https://www.bitmaintech.com">{{ trans('global.footer.Antminer') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.antpool.com">{{ trans('global.footer.Antpool') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.hashnest.com">{{ trans('global.footer.Hashnest') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.minerlink.com">{{ trans('global.footer.Minerlink') }}</a></li>
                    </ul>
                </div>
                <div class="links-column">
                    <div class="links-category">{{ trans('global.footer.Company') }}</div>
                    <ul class="links-list">
                        <li class="links-list-item"><a target="_blank" href="https://www.bitmaintech.com/about.htm">{{ trans('global.footer.About_us') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.bitmaintech.com/recruit.htm">{{ trans('global.footer.Join_us') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.bitmaintech.com/about.htm">{{ trans('global.footer.Contact_us') }}</a></li>
                        @if(\App::getLocale() == "en")
                            <li class="links-list-item"><a target="_blank" href="https://blog.btc.com/">{{ trans('global.footer.Blog') }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="links-column">
                    <div class="links-category">{{ trans('global.footer.Media') }}</div>
                    <ul class="links-list">
                        <li class="links-list-item"><a target="_blank" href="http://weibo.com/u/5995599784">{{ trans('global.footer.Official_Weibo') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://blog.btc.com/">{{ trans('global.footer.Community') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://twitter.com/btccom_official">{{ trans('global.footer.Twitter') }}</a></li>
                        <li class="links-list-item"><a target="_blank" href="https://www.facebook.com/btccom/">{{ trans('global.footer.Facebook') }}</a></li>
                    </ul>
                </div>
                <div class="links-column">
                    <div class="links-category">{{ trans('global.footer.Developers') }}</div>
                    <ul class="links-list">
                        <li class="links-list-item"><a href="{{ route('api') }}">{{ trans('global.footer.api') }}</a></li>
                    </ul>
                    <ul class="links-list">
                        <li class="links-list-item">
                            <a target="_blank" href="{{ sprintf('https://bmfeedback.bitmain.com/feedback/app_feedback/?app=BTC.COM&imei=1236456456&lan=%s',
                                                str_replace('-', '_', \App::getLocale())) }}">
                                {{ trans('global.common.feed-back') }}</a></li>
                    </ul>
                </div>
                <div class="platform-swtich">
                    <i class="glyphicon glyphicon-phone"></i>
                    <a href="javascript:">{{ trans('global.footer.gotomobilesite') }}</a>
                </div>
                <img src="/images/app/pc/qr-code@2x.png" style="position: absolute; right: -10px; top: 30px; height:128px">
                <script>
                    document.querySelector('.platform-swtich').addEventListener('click', function() {
                        document.cookie = 'platform=mobile;path=/;domain={{root_domain(env('MOBILE_HOST'))}};expires=-1';
                        location.reload();
                    });
                </script>
            </div>
        </div>
    </div>
</footer>
