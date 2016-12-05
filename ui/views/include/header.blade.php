<header class="header">
    <div class="container">
        <div class="row">
            <div class="logo">
                <div class="logo-inner">
                    <a href="{{ route('index') }}" class="text-hide logo-link">{{ $title }}</a>
                    @if (env('IS_TESTNET3', true))
                        <div class="logo-testnet3"></div>
                    @endif
                </div>
            </div>
            <nav class="nav">
                <ul>
                    <li class="nav-item">
                        <a href="https://pool.btc.com/" target="_blank">{{ trans('global.menu.pool') }}</a>
                    </li>
                    <?php
                    $menus = ['blockList', 'stats', 'tools', 'application', 'wallet'];
                    ?>
                    @foreach ($menus as $m)
                        <li class="nav-item{{ Route::currentRouteName() == $m ? ' active' : '' }}">
                            <a href="{{ ($m == 'wallet') ? 'https://wallet.btc.com/' : route($m) }}">{{ trans('global.menu.' . $m) }}</a>
                             {{--统计添加 new 标记 --}}
                            @if ($m == '')
                                <i class="icon-new-flag"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{--<div class="preference">--}}
                {{--<a href="javascript:" data-toggle="popover" data-placement="bottom">{{ trans('global.preference') }}</a>--}}
            {{--</div>--}}
            {{--@template--}}
            {{--<link rel="import" href="/components/preference/index.html?__inline"/>--}}
            {{--@endtemplate--}}
            {{--@section('script_resource_inline')@parent--}}
            {{--<script src="/components/preference/index.js?__inline"></script>--}}
            {{--@endsection--}}
            <div class="lang">
                <div class="lang-active">
                    <a href="javascript:" data-toggle="dropdown">
                        {{ trans('global.lang.' . \App::getLocale()) }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu lang-dropdown">
                        @foreach (config('app.languages') as $lang)
                        @if (\App::getLocale() == $lang)
                        <li class="lang-option disabled">
                            <a href="javascript:">{{ trans('global.lang.' . $lang) }}</a>
                        </li>
                        @else
                        <li class="lang-option">
                            <a href="javascript:" onclick="setLanguageCookie('{{ $lang }}')">{{ trans('global.lang.' . $lang) }}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                @inlinescript
                <script>
                    function  setLanguageCookie(lang) {
                        Cookies.set('lang', lang, { expires: 7, path: '/' });
                        location.reload();
                    }
                </script>
                @endinlinescript
            </div>

            <div class="searchbar">
                <div class="searchbar-inner">
                    <form action="{{ route('search') }}" method="GET" class="searchbar-form clearfix" onsubmit="this.q.value = this.q.value.trim()">
                        <button class="searchbar-submit" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <div class="searchbar-input-container">
                            <input type="search" class="searchbar-input" name="q"
                                   placeholder="{{ trans('global.searchPlaceHolder') }}"
                                   autocomplete="off"
                                   onfocus="$(this).addClass('active')"
                                   onblur="this.value.length > 1 || $(this).removeClass('active')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
