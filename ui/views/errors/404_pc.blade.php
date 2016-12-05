@extends('layout')

@section('body')
    <div class="container e404">
        <div class="row e404-inner">
            <div class="e404-img"></div>
            <div class="e404-desc">
                {{ trans('global.page.404.desc') }}
            </div>
        </div>
    </div>
@endsection