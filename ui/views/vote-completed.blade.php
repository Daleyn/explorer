@extends('layout')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        options_url: "{!! $options_url !!}",
        csrf_token: "{!! $csrf_token !!}",
        vote_hash:  "{!! $vote_hash !!}",
        js_trans: {!! json_encode($js_trans) !!},

    };
</script>
@endsection
@section('body')
    <div class="main-body vote">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{route('subject.list') }}"> {{ trans('global.menu.vote') }} </a></li>
                    <li>{{trans('global.page.vote-completed.title')}}</li>
                </ol>
            </div>

            <div class="row v-row-left">
                <div class="panel panel-bm" style="margin-bottom:10px;">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{trans('global.page.vote-completed.vote-title')}}</div>
                    </div>
                    <div class="panel-body" style="margin-left: -20px;">
                        <div class="v-as-left v-cast-top">
                            <span>{{$vote['title']}}</span>
                            <div class="v-cast-join" style="margin-top: 4px;">
                                <span>{{trans('global.page.vote-completed.weight-deadline', ['date' => $vote['vote_deadline'], "height" => $vote['vote_height']])}}</span>
                                <span class="v-help v-cast-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-completed.weight-help')}}"></span>
                            </div>
                            <div class="v-cast-join" style="margin-top:30px;">
                                @if($vote['all_count'] <= 1)
                                    <span>{{trans('global.page.vote-completed.weight-title-one', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                @else
                                    <span>{{trans('global.page.vote-completed.weight-title', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                @endif
                                <span class="v-help v-cast-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-completed.deadline-help')}}"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{trans('global.page.vote-completed.options-title')}}</div>
                    </div>
                    <div class="panel-body" style="padding-left: 20px;">
                        <div id="c-op">

                            @foreach($vote['options'] as $key => $value)
                            <div class="c-div" onclick="showCast(this)">
                                <p class="weight" style="width:{{intval($value['length']*775/100)}}px;"></p>
                                <h4>{{$key}}</h4>
                                <span class="c-left">{{$value['context']}}</span>
                                <span class="c-right">
                                     <div>
                                         <span>{{$value['weight']}} btc</span>
                                         <span>{{$value['percentage']}}%</span>
                                     </div>
                                     <div class="radios deadline-radio"></div>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="v-others" style="margin-left: 190px; margin-top: 0px;">
                    <div  data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-completed.verify-title-help')}}" >
                        <a href="{{route("vote.verify", ['vote_key' => $vote['vote_hash']])}}" target="_blank">{{trans('global.page.vote-completed.other-verify')}}</a>
                        <span class="v-icon v-validation" ></span>
                    </div>
                    <div  data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-completed.other-title-help')}}" >
                        <span>{{trans('global.page.vote-completed.other-title')}}</span>
                        <span class="v-icon v-collection" ></span>
                    </div>
                </div>
            </div>
            <div class="row v-row-right">
                <div class="panel panel-bm">
                    <div class="panel-heading" style="padding-left:10px;">
                        <div class="panel-heading-title">{{trans('global.page.vote-completed.detail-title')}}</div>
                    </div>
                    <div class="panel-body" style="padding-left: 10px;">
                        <table class="cast-tb">
                            @if(!empty($vote['promoter']))
                            <tr>
                                <td>{{trans('global.page.vote-completed.vote-creator')}}</td>
                                <td>{{$vote['promoter']}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{trans('global.page.vote-completed.vote-start')}}</td>
                                <td>
                                    <span>{{$vote['created_at']}} UTC</span>
                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('global.page.vote-completed.vote-deadline')}}</td>
                                <td>
                                    <span>{{$vote['vote_deadline']}} UTC</span>
                                    <span class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-completed.deadline-help')}}" ></span>
                                </td>
                            </tr>
                            <tr id="note">
                                <td>{{trans('global.page.vote-completed.context')}}</td>
                                <td>{{$vote['context']}}</td>
                            </tr>
                        </table>
                        <div id="cast-info" style="margin-top: 48px;">
                            <div class="cast-title" id="addressCount"></div>
                            <div class="vote-height" >
                                <div class="hot-title">{{trans('global.page.vote-completed.comments-hot')}}</div>
                                <div id="hot"> </div>
                                <div class="hot-title new-title">{{trans('global.page.vote-completed.comments-recent')}}</div>
                                <div id="new"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section("script_resource_inline")@parent
<script>
    var op="";
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
        var num=-1;
        var colors=["#d49ec5","#8d7bc0","#b8e986","#ecb36d","#3c78c2","#fd8d8c","#cd5588","#4f6390","#F0AFA4","#85CBBB"];
        $("#c-op p").each(function(){num++;$(this).css("background-color",colors[num]);})

    });
    var showCast=function(obj){
        var newop=$(obj).find("h4:eq(0)").text();
        if(op==newop){                                                //再一次点击某选项
            $(obj).find("div:eq(1)").toggleClass("deldlinecheck")
            if($(obj).find("div:eq(1)").hasClass("deldlinecheck")){
                $("#note").hide();
                $("#cast-info").show();
            }else{
                $("#note").show();
                $("#cast-info").hide();
            }
        }else{                                                       //第一次点击或者换选项点击
            $("#note").hide();
            $("#cast-info").show();
            $(".radios").removeClass("deldlinecheck");
            $(obj).find("div:eq(1)").addClass("deldlinecheck");
            var formdata={
                "_token":globals.csrf_token,
                "option": newop,
                "key":globals.vote_hash,
            };
            $.ajax({method : "POST",
                url:globals.options_url,
                data:formdata,
                headers: { "X-CSRFToken": globals.csrf_token},
                dataType: 'json',

            }).done(function( msg ){
                if(msg.flag){
                    if(msg.flag==true){
                        if(msg.recent_votes==null){
                            $("#addressCount").text(globals.js_trans['empty-help-a']+newop+globals.js_trans['empty-help-b']);
                            $("#hot").html("");
                            $("#new").html("");
                            $("#new").prev().hide();
                        }else{
                            $("#addressCount").text(msg.recent_votes.length+globals.js_trans['recent-help']+newop+globals.js_trans['empty-help-b'])
                        }
                        if(msg.hot_votes==null){
                            $("#hot").prev().hide();
                            $("#hot").html("");
                        }else{
                            $("#hot").prev().show();
                            $("#hot").html("");
                            for(var i=0;i<msg.hot_votes.length;i++){
                                var dt=' <div class="vote-option">'+
                                        '<span>'+msg.hot_votes[i].user_address+'</span>'+
                                        '<span>'+globals.js_trans["weight-title"]+msg.hot_votes[i].weight+' Btc</span>'+
                                        '<span>'+msg.hot_votes[i].vote_msg+'</span>'+
                                        ' </div>';
                                $("#hot").append(dt);
                            }
                        }
                        if(msg.recent_votes!=null){
                            $("#new").html("");
                            $("#new").prev().show();
                            for(var i=0;i<msg.recent_votes.length;i++){
                                var dt='<div class="vote-option">'+
                                        '<span>'+msg.recent_votes[i].user_address+'</span>'+
                                        '<span>'+globals.js_trans["weight-title"]+msg.recent_votes[i].weight+' Btc</span>'+
                                        '<span>'+msg.recent_votes[i].vote_msg+'</span>'+
                                        ' </div>';
                                $("#new").append(dt);
                            }
                        }

                    }
                }
            });
        }
        op=newop;
    }
</script>
@endsection