@extends('layout')

@section('style_resource_inline')@parent
<style>
    .subscribe_status_img {
        width: 32px; height: 32px;
        margin-top: 159px;
        align-content: center;
    }

    .subscribe_status_message {
        margin-top: 20px;
        font-size: 16px;
        color: #888888;
    }

</style>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <div class="panel panel-bm indexBlockList">
                    <div class="panel-body">
                        <div class="row" style="text-align: center">
                            @if ($subscribe_status == 'success')
                                <img src="/images/icon-submit-success@2x.png" class="subscribe_status_img">
                            @else
                                <img src="/images/icon-submit-cancel@2x.png" class="subscribe_status_img">
                            @endif

                            <div class="subscribe_status_message">{!! $info !!}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
