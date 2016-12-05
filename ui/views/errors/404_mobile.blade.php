<!DOCTYPE html>
<html lang="{{ $lang }}" style="height: 100%">

@include('mobile.include.head')

<body class="e404">

@include('mobile.include.header')

<section class="main-body">
    <div class="table-like">
        <div class="table-cell-like">
            <div class="e404-img-container">
                <img src="/mobile_images/404@3x.png" width="240" height="113" alt="Page Not Found">
            </div>
            <div class="e404-desc">
                {{ trans('global.page.404.desc') }}
            </div>
        </div>
    </div>
</section>

@include('mobile.include.footer')

@yield('template')
@yield('script_resource')
@yield('script_resource_inline')
@include('mobile.ga')
</body>
</html>