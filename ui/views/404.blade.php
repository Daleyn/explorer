@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="notfound">
                        <div class="notfound-inner">
                            <div class="notfound-pic"></div>
                            <form action="{{ route('search') }}" method="GET" class="notfound-form" onsubmit="this.q.value = this.q.value.trim()">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="{{ trans('global.searchPlaceHolder') }}" value="{{ session('q', '') }}" autocomplete="off" name="q" autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn" type="submit">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </span>
                                </div>

                                <p class="notfound-desc">{{ trans('global.page.search.desc') }}</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection