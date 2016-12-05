<footer class="footer">
    <div class="lang">
        <ul class="clearfix">
            <?php $lang_count = 0; ?>
            @foreach (config('app.languages') as $lang)
                @if($lang_count % 3 == 0)
                    </ul>
                    <ul>
                @endif

                @if (\App::getLocale() == $lang)
                <li>
                    <a href="javascript:" onclick="setLanguageCookie('{{ $lang }}')" class="active">{{ trans('global.lang.' . $lang) }}</a>
                </li>
                @else
                <li>
                    <a href="javascript:" onclick="setLanguageCookie('{{ $lang }}')">{{ trans('global.lang.' . $lang) }}</a>
                </li>
                @endif
            <?php $lang_count++; ?>
            @endforeach
        </ul>
    </div>
    <div class="footer-note">
        <span class="footer-copyright">&copy; BTC.COM 2016</span>
        <a href="javascript:" class="footer-platform-switch">{{ trans('global.footer.gotopcsite') }}</a>
        @script('/lib/js.cookie.js')
        <script>
            document.querySelector('.footer-platform-switch').addEventListener('click', function() {
                document.cookie = 'platform=pc;path=/;domain={{root_domain(env('PC_HOST'))}};expires=-1';
                location.reload();
            });

            function  setLanguageCookie(lang) {
                Cookies.set('lang', lang, { expires: 7, path: '/' });
                location.reload();
            }
        </script>
    </div>
</footer>