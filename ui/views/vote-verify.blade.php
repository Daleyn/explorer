@extends('layout')
@section('script_resource_prepend')@parent
<script type="text/javascript">

</script>
@endsection
@section('body')
    <div class="main-body vote">
        <div class="container">
            <div class="row" >
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{route('subject.list')}}"> {{ trans('global.menu.vote') }} </a></li>
                    @if($is_res == true)
                    <li id="v-list-theme">{{ trans('global.page.vote-verify.title-b') }}</li>
                    @else
                    <li id="v-list-theme">{{ trans('global.page.vote-verify.title-a') }}</li>
                    @endif
                </ol>
            </div>

            <div class="row v-row-left">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        @if($is_res == true)
                            <div class="panel-heading-title">{{ trans('global.page.vote-verify.hash-title-b') }}</div>
                        @else
                            <div class="panel-heading-title">{{ trans('global.page.vote-verify.hash-title-a') }}</div>
                        @endif
                    </div>
                    <div class="panel-body" style="padding-left: 20px;">
                        <div class="v-active-paytitle" style="margin-bottom: 5px;">{{$vote_title}}</div>
                        <div class="v-verify-note" style="margin-bottom: 5px;">{{ trans('global.page.vote-verify.context-title') }}</div>
                        <div><textarea class="v-verify-content">{{$verify_text}}</textarea></div><br/>
                        <div>
                            <div style="float:left; width:220px">{{ trans('global.page.vote-verify.check-crc-title') }} <span style="padding-left:2px;">{{ trans('global.page.vote-verify.check-crc') }}</span></div>
                            @if($vote_op_tx == false)
                                <a class="v-verify-lookblock" href="#" target="_blank">{{ trans('global.page.vote-verify.wait-label') }}</a>
                            @else
                                <a class="v-verify-lookblock" href="{{route('search.general', ['q' => $vote_op_tx])}}" target="_blank">{{ trans('global.page.vote-verify.chain-title') }}</a>
                            @endif
                        </div>
                        <div class="v-votehash">
                            {{$vote_hash}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row v-row-right">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.vote-verify.intro-title') }}</div>
                    </div>
                    <div class="panel-body">
                       <div class="v-verify-express">
                           {{ trans('global.page.vote-verify.intro-comments') }}
                       </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection