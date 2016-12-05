@extends('layout')

@script('/components/tools/tx-publish.js')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        trans: {!! json_encode($trans) !!},
        blockAPIEndpoint: {!! json_encode($endpoint) !!}
    };
</script>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('tools') }}">{{ trans('global.menu.tools') }}</a></li>
                    <li>{{ trans('global.page.tool-publish.title') }}</li>
                </ol>
            </div>

            <div class="row tx-publish">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.tool-publish.title') }}</div>
                    </div>
                    <div class="panel-body">
                        <div class="broadcast-trade-content">
                            <div class="broadcast-trade-content-title">
                                <p>{{ trans('global.page.tool-publish.prepare.desc') }}</p>
                            </div>
                            <form action="#" method="post" onsubmit="return false">
                                <textarea id="broadcast-trade-text" autofocus="autofocus" onkeyup="canSubmit()"></textarea>
                                <div class="show-error"></div>
                                <input class="btn btn-bm btn-primary" id="broadcast-trade-btn" type="submit" disabled="disabled" value="{{ trans('global.page.tool-publish.prepare.publish') }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection