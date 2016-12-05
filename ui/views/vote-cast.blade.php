@extends('layout')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        options_url: "{!! $options_url !!}",
        cast_url: "{!! $cast_url!!}",
        vote_hash: "{!! $vote['vote_hash']!!}",
        csrf_token: "{!! $csrf_token !!}",
        trans: {!! json_encode($trans) !!},
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
                    <li><a href="{{route('subject.list')}}"> {{ trans('global.menu.vote') }} </a></li>
                    <li>{{trans('global.page.vote-cast.title')}}</li>
                </ol>
            </div>

            <div class="row v-row-left">
                <div class="panel panel-bm" style="margin-bottom:10px;">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{trans('global.page.vote-cast.vote-title')}}</div>
                    </div>
                    <div class="panel-body" style="padding-left: 20px;">
                        <div class="v-as-left v-cast-top">
                            <span>{{$vote['title']}}</span>
                            @if($cast_deadline <=0)
                            <span>{{trans('global.page.vote-cast.vote-deadline-today')}}</span>
                            @elseif($cast_deadline ==1)
                                <span>{{trans('global.page.vote-cast.vote-deadline-one-today')}}</span>
                            @else
                            <span>{{trans('global.page.vote-cast.vote-deadline', ['days_num' => $cast_deadline])}}</span>
                            @endif
                            <div class="v-cast-join">
                                @if($vote['all_count'] <= 1)
                                    <span>{{trans('global.page.vote-cast.weight-title-one', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                @else
                                    <span>{{trans('global.page.vote-cast.weight-title', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                @endif
                                <span class="v-help v-cast-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-cast.options-help')}}"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{trans('global.page.vote-cast.options-title')}}</div>
                    </div>
                    <div class="panel-body" style="padding-left: 20px;">
                        <div id="c-op">
                            @foreach($vote["options"] as $key => $value)
                            <div class="c-div" onclick="showCast(this)">
                                <p class="weight" style="width:{{intval($value['length']*775/100)}}px;"></p>
                                <h4>{{$key}}</h4>
                                <span class="c-left">{{$value['context']}}</span>
                                <span class="c-right">
                                     <div>
                                         <span>{{$value['weight']}} btc</span>
                                         <span>{{$value['percentage']}}%</span>
                                     </div>
                                     <div class="radios"></div>
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="cast-message">
                            <input id="message" type="text" maxlength="100" onkeyup="showlimit($(this),100);"  placeholder="{{trans('global.page.vote-cast.comments-help')}}" style="width:775px;margin-bottom:30px;">
                            <span class="limit">100</span>
                        </div>
                        <span class="v-error" style="margin-top: -25px; margin-left: 22px;"></span>
                    </div>
                </div>

                <div>
                    <input id="v-btn-sub" type="button" class="btn"  value="{{trans('global.page.vote-cast.commit-button')}}" onclick="confirmVote()">
                    <div class="v-others">
                        <div data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-cast.tools-three-title')}}">
                            <a href="{{route("vote.verify", ['vote_key' => $vote['vote_hash']])}}" target="_blank">{{trans('global.page.vote-cast.tools-three')}}</a>
                            <span class="v-icon v-validation" ></span>
                        </div>
                        <div  data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-cast.tools-two-help')}}" >
                            <span>{{trans('global.page.vote-cast.tools-two')}}</span>
                            <span class="v-icon v-collection" ></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row v-row-right">
                <div class="panel panel-bm">
                    <div class="panel-heading" style="padding-left:10px;">
                        <div class="panel-heading-title">{{trans('global.page.vote-cast.detail-title')}}</div>
                    </div>
                    <div class="panel-body" style="padding-left: 10px;">
                        <table class="cast-tb">
                            @if(!empty($vote['promoter']))
                            <tr>
                                <td>{{trans('global.page.vote-cast.promoter')}}</td>
                                <td>{{$vote['promoter']}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{trans('global.page.vote-cast.start')}}</td>
                                <td>
                                    <span>{{$vote['created_at']}} UTC</span>

                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('global.page.vote-cast.deadline')}}</td>
                                <td>
                                   <span> {{$vote['vote_deadline']}} UTC</span>
                                    <span class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-cast.deadline-help')}}" ></span>
                                </td>
                            </tr>
                            @if(!empty($vote['context']))
                            <tr id="note">
                                <td>{{trans('global.page.vote-cast.context')}}</td>
                                <td>{{$vote['context']}}
                                </td>
                            </tr>
                            @endif
                        </table>
                        <div id="cast-info">
                            <div class="cast-title" id="addressCount" style="margin-top:33px;"></div>
                            <div class="vote-height">
                                <div class="hot-title">{{trans('global.page.vote-cast.comments-hot')}}</div>
                                <div id="hot"></div>
                                <div class="hot-title new-title">{{trans('global.page.vote-cast.comments-recent')}}</div>
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
    var showlimit=function(obj,num){
        var count=obj[0].value.length;
        if(count<=num){
            obj.next().removeClass("limitWords")
            obj.next().text(num-count);
            if(num-count==0){
                obj.next().addClass("limitWords")
            }
        }
    }
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
        var num=-1;
        var colors=["#d49ec5","#8d7bc0","#b8e986","#ecb36d","#3c78c2","#fd8d8c","#cd5588","#4f6390","#F0AFA4","#85CBBB"];
        $("#c-op p").each(function(){num++;$(this).css("background-color",colors[num]);})
    });
    var op="";
    var showCast=function(obj){
        var newop=$(obj).find("h4:eq(0)").text();
        if(op==newop){                                                //再一次点击某选项
            $(obj).find("div:eq(1)").toggleClass("radioCheck")
            if($(obj).find("div:eq(1)").hasClass("radioCheck")){
                $("#note").hide();
                $("#cast-info").show();
            }else{
                newop="";
                $("#note").show();
                $("#cast-info").hide();
            }
        }else{                                                       //第一次点击或者换选项点击
            $("#note").hide();
            $("#cast-info").show();
            $(".v-error").html("");
            $(".radios").removeClass("radioCheck");
            $(obj).find("div:eq(1)").addClass("radioCheck")
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
                                        '<span>'+globals.js_trans['weight-title']+msg.hot_votes[i].weight+' Btc</span>'+
                                        '<span>'+msg.hot_votes[i].vote_msg+'</span>'+
                                        ' </div>';
                                $("#hot").append(dt);
                            }
                        }
                        if(msg.recent_votes!=null){
                            $("#new").prev().show();
                            $("#new").html("");
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

    var confirmVote = function(){
        var vote_option=op;
        var vote_msg=$.trim($("#message").val());
        if(vote_option==""){
            $(".v-error").html(globals.trans['js-alter']);
            return false;
        }
        window.location.href=globals.cast_url+"/?vote_msg=" + vote_msg + "&vote_option="+vote_option;
    }
</script>
@endsection