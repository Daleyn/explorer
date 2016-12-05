@extends('layout')

@script('/components/tools/tx-public-note.js')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        trans: {!! json_encode($trans) !!}
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
                    <li>{{ trans('global.page.tx-public-note.title') }}</li>
                </ol>
            </div>
            <div class="row">
                <div class="tx-publicNote">
                    <div class="panel panel-bm">
                        <div class="panel-heading"><div class="panel-heading-title">{{ trans('global.page.tx-public-note.panel-title') }}</div></div>
                        <div class="panel-body">
                            <div class="trade-note">
                                <div class="trade-note-option trade-hash clearfix">
                                    <label>{{ trans('global.page.tx-public-note.transaction-hash') }}</label>
                                    <input id="trade-hash-text" class="trade-note-text" type="text" autofocus="autofocus" onkeyup="checkHash();">
                                    <div class="show-hash-error"></div>
                                </div>
                                <form id="trade-note" action="#" method="post" onsubmit="return false">
                                    <div class="trade-note-option clearfix">
                                        <label>{{ trans('global.page.tx-public-note.address') }}</label>
                                        <select id="trade-address" class="trade-note-text"></select>
                                    </div>
                                    <div class="trade-note-option clearfix">
                                        <label>{{ trans('global.page.tx-public-note.public-note') }}</label>
                                        <input id="public-note" class="trade-note-text" type="text" autocomplete="off" onkeyup="canSubmit();changeAutographText();">
                                    </div>
                                    <div class="trade-note-option clearfix">
                                        <label>{{ trans('global.page.tx-public-note.message') }}</label>
                                        <p id="autograph-text" class="trade-note-text">{{ trans('global.page.tx-public-note.message-placeholder') }}</p>
                                    </div>
                                    <div class="trade-note-option clearfix">
                                        <label>{{ trans('global.page.tx-public-note.signature') }}</label>
                                        <textarea id="trade-note-text" class="trade-note-text" onkeyup="canSubmit()"></textarea>
                                    </div>
                                    <div class="show-error"></div>
                                    <input id="trade-note-btn" class="btn btn-primary btn-bm" type="submit" disabled="disabled" value="{{ trans('global.page.tx-public-note.submit') }}" onclick="submitForm()">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection