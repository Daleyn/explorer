<!DOCTYPE html>
<html lang="{{ $lang }}">
@include('mobile.include.head')
<body>

@include('mobile.include.header')

<section class="main-body">
    @section('body')
        <h1>Hello World</h1>
    @show
</section>

@include('mobile.include.footer')

<div id="back-top-btn" class="back-top-btn fr">
    <a href="javascript:">
        <img src="/mobile_images/icon-backtop@3x.png?__inline" alt="返回顶部" width="32" height="32">
    </a>
</div>

@yield('template')
@yield('script_resource')
@yield('script_resource_inline')
@include('mobile.ga')
</body>
</html>