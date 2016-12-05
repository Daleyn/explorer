<header class="header">
    <h1 class="header-title">BTC.com - {{ $title }}</h1>
    <nav class="header-nav">
        @if (Route::currentRouteName() == 'index')
            <div class="logo">
                <img src="/mobile_images/logo@3x.png?__inline" alt="BTC.com" width="66" height="31">
                <a class="mobile_phone" href="{{ route('application') }}">
                    <img src="/images/app/h5/icon-mobile@2x.png" width="10" height="18" >
                </a>
            </div>
        @else
            <div class="title"><span>{{ $title }}</span></div>
            <div class="nav-item nav-back">
                <a href="javascript:" class="nav-back-btn"><i class="icon icon-back"></i></a>
                <script>
                    document.querySelector('.nav-back-btn').addEventListener('click', function() {
                        var referer = document.referrer;
                        var baseDomain = '{{ root_domain(env('PC_HOST')) }}';
                        if (~referer.indexOf(baseDomain)) {
                            return history.back();
                        } else {
                            location.href = '/';
                        }
                    });
                </script>
            </div>
            <div class="nav-item nav-home">
                <a href="{{ route('index') }}"><i class="icon icon-home"></i></a>
            </div>
        @endif
    </nav>

    <section class="search">
        <form action="{{ route('search') }}" method="GET">
            <div class="search-button">
                <button><i class="icon icon-search-button"></i></button>
            </div>
            <div class="search-box">
                <input type="search" name="q" class="search-box-input" autocomplete="off"
                       placeholder="{{ trans('global.searchPlaceHolder') }}">
                {{--<i class="icon icon-search-clear"></i>--}}
            </div>
            <div class="search-notfound" style="display: none;">
                {{ trans('global.common.mobile_notfound_tip') }}
                <a href="javascript:" class="search-notfound-clear">
                    {{ trans('global.common.mobile_notfound_clear') }}
                </a>
            </div>
            @inlinescript
            <script>
                $(function() {
                    var errorTip = $('.search-notfound');
                    var input = $('.search-box-input');
                    $('.search > form').on('submit', function() {
                        var v = input.val().trim();
                        if (!v) return false;

                        $.get('/' + {{ \App::getLocale() }} + '/search/' + v)
                                .then(function(data) {
                                    if (data.next) {
                                        location.href = data.next;
                                    } else {
                                        errorTip.show();
                                    }
                                });

                        return false;
                    });

                    input.on('input', function() {
                        errorTip.hide();
                    });

                    $('.search-notfound-clear').click(function() {
                        errorTip.hide();
                        input.val('');
                        input.focus();
                    });
                });
            </script>
            @endinlinescript
        </form>
    </section>
    <section>
        <div class="popup" id="ad_popup">
            <div class="popup1"></div>
            <div class="popup2"><marquee>{{ trans('global.page.applications.mobile-app-now-available') }}</marquee></div>
            <a class="popup3" href="{{ route('application') }}">
              <button class="btn-look" id="adhide">{{ trans('global.page.applications.detail') }}</button>
            </a>
        </div>
        @inlinescript
        <script>
            $(document).ready(function(){
                if(localStorage.lastclick_time){
                    var nowtime=Date.parse(new Date());
                    var lasttime=localStorage.lastclick_time;
                    var dt=((nowtime-lasttime)/86400000).toFixed(2);
                    if(dt>=6){
                        $("#ad_popup").show();
                    }
                }
                else{
                    $("#ad_popup").show();

                }
                $(".popup1").click(function(){
                    $("#ad_popup").hide();
                    localStorage.lastclick_time = Date.parse(new Date());
                })
            })
        </script>
        @endinlinescript
    </section>
</header>
