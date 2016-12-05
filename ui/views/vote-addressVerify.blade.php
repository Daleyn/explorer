@extends('layout')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        store_url: "{!! $store_url!!}",
        vote_hash: "{!! $vote['vote_hash']!!}",
        all_weight: "{!! $vote['all_weight']!!}",
        option_weight: "{!! $options['weight']!!}",
        csrf_token: "{!! $csrf_token !!}",
        sign_message: "{!! $sign_message !!}",
        vote_option: "{!! $vote_option !!}",
        option_context: "{!! $options["option_context"] !!}",
        vote_msg: "{!! $vote_msg !!}",
        trans: {!! json_encode($trans) !!},
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
                    <li>{{trans('global.page.vote-cast-verify.title')}}</li>
                </ol>
            </div>

            <div class="row v-row-left">
                <div id="vote_sign">
                    <div class="panel panel-bm" style="margin-bottom:10px;">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{trans('global.page.vote-cast-verify.vote-head')}}</div>
                        </div>
                        <div class="panel-body" style="padding-left: 40px;">
                            <div class="av-title" style="margin-top: 0px;">{{trans('global.page.vote-cast-verify.vote-title')}}</div>
                            <div class="av-text">{{$vote['title']}}</div>
                            <div class="av-title">{{trans('global.page.vote-cast-verify.option-title')}}</div>
                            <div>
                                <div id="opDiv" class="c-div" style="margin-left:0px;">
                                    <p class="weight" style="width:{{intval($options['length']*775/100)}}px;"></p>
                                    <h4>{{$options['vote_option']}}</h4>
                                    <span class="c-left">{{$options['option_context']}}</span>
                                <span class="c-right">
                                     <div>
                                         <span>{{$options['weight']}} btc</span>
                                         <span>{{$options['percentage']}}%</span>
                                     </div>
                                     <div class="radios" style="display: none;"></div>
                                </span>
                                </div>
                            </div>
                            @if(!empty($vote_msg))
                            <div class="av-title" style="margin-top: 17px;">{{trans('global.page.vote-cast-verify.comments-title')}}</div>
                            <div class="av-text" style="word-break:break-all; width:778px;">{{$vote_msg}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-bm">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{trans('global.page.vote-cast-verify.verify-title')}}</div>
                        </div>
                        <div class="panel-body" style="padding-left: 40px;padding-top: 10px">
                            <div class="av-verify">
                                <div class="av-express">{{trans('global.page.vote-cast-verify.vote-help')}}</div>
                                <div style="margin-top: 38px;">{{trans('global.page.vote-cast-verify.step-one')}}</div>
                                <input id= "v-cast-address" type="text"  style="width:781px;margin-top: 5px;" ><br>
                                <div style="margin-top: 35px;" class="v-active-title v-active-signtext">
                                    <span>{{trans('global.page.vote-cast-verify.step-two')}}</span>
                                    {{--<span class="v-active-sign" style="width:336px;" tabindex="2">{{$sign_message}}</span>--}}
                                    <input type="text" value="{{$sign_message}}" class="v-active-sign" onclick="focus();select()" style="width:337px!important;">
                                    <span>{{trans('global.page.vote-cast-verify.step-two-a')}} </span>
                                </div>
                                <textarea  id= "v-cast-signature"  class="av-textarea" onkeydown="$('#v-verifyerror').text('')"></textarea>
                                <div class="v-ck" style="margin-top: 129px;">
                                    <input type="checkbox" id="readconfirm" onclick="duty()"/>
                                    <span  class="v-Words "onclick="$('#readconfirm').click()" >{{trans('global.page.vote-cast-verify.commit-title')}}</span>
                                </div>
                                <div class="v-error" style="margin-left: 22px; line-height: 20px;height:20px;" id="v-verifyerror"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input id="vote-confirm" type="button" disabled="disabled" class="btn submit-unchecked"  value="{{trans('global.page.vote-cast-verify.button-title')}}" onclick="confirm()" >
                    </div>
                </div>
                <div id="vote_success">
                    <div class="panel panel-bm">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{trans('global.page.vote-cast-verify.suc-head')}}</div>
                        </div>
                        <div class="panel-body" style="padding-left: 40px;">
                            <div class="success-panel">
                                <div class="av-title" style="margin-top: 8px;">{{trans('global.page.vote-cast-verify.vote-title')}}</div>
                                <div class="av-text1">{{$vote['title']}}</div>
                                <div class="av-title">{{trans('global.page.vote-cast-verify.option-title')}}</div>
                                <div>
                                    <div class="c-div" style="margin-left:0px;">
                                        <p id = "c-weight" class="weight" ></p>
                                        <h4>{{$options['vote_option']}}</h4>
                                        <span class="c-left">{{$options['option_context']}}</span>
                                <span class="c-right">
                                     <div>
                                         <span id = "c-bit">{{$options['weight']}} btc</span>
                                         <span id="c-percentage">{{$options['percentage']}}%</span>
                                     </div>
                                     <div class="radios" style="display: none;"></div>
                                </span>
                                    </div>
                                </div>
                                @if(!empty($vote_msg))
                                <div class="av-title" style="margin-top: 20px;">{{trans('global.page.vote-cast-verify.comments-title')}}</div>
                                <div class="av-text1" style="word-break: break-all">{{$vote_msg}}</div>
                                @endif
                                <div class="av-title av-weight">
                                    <span class="">{{trans('global.page.vote-cast-verify.weight-help')}}</span>
                                    <span class="v-help av-power" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-cast-verify.options-help')}}"></span>
                                </div>
                                <div class="av-text1" style="clear: both" id="av-power">{{$options['weight']}} Btc</div>
                            </div>
                        </div>
                    </div>
                    <div class="v-others" style="margin-left: 210px; margin-top: 0px;">
                        <div>
                            <a href="{{route('subject.list')}}" target="_blank">{{trans('global.page.vote-cast-verify.vote-other')}}</a>
                            <span class="v-icon v-other" ></span>
                        </div>
                        <div>
                            <a href="{{route('subject.show', ['key'=> $vote['vote_hash']])}}" target="_blank">{{trans('global.page.vote-cast-verify.vote-link')}}</a>
                            <span class="v-icon v-look" ></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section("script_resource_inline")@parent
<script>
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
        var op=$("#opDiv h4").text();
        var colors={"A":"#d49ec5","B":"#8d7bc0","C":"#b8e986","D":"#ecb36d","E":"#3c78c2","F":"#fd8d8c","G":"#cd5588","H":"#4f6390","I":"#F0AFA4","J":"#85CBBB"};
        $(".weight").css("background-color",colors[op]);
        if ($("#readconfirm").is(':checked')) {
            $("#create").removeClass("submit-unchecked");
            $('#create').removeAttr("disabled");
        }
    });
    var duty = function () {
        if ($("#readconfirm").is(':checked')) {
            $("#vote-confirm").removeClass("submit-unchecked");
            $('#vote-confirm').removeAttr("disabled");
        }else{
            $("#vote-confirm").addClass("submit-unchecked");
            $('#vote-confirm').attr("disabled","disabled");
        }
    }

    var confirm = function(){
        var address=$.trim($("#v-cast-address").val());
        var signature=$.trim($("#v-cast-signature").val());
        if(address==""){
            $(".v-error").html(globals.trans['js-address-alter']);
            return false;
        }
        if(signature==""){
            $(".v-error").html(globals.trans['js-signature-alter']);
            return false;
        }
        var formdata={
            "_token":globals.csrf_token,
            "address": address,
            "message":globals.sign_message,
            "signature": signature,
            "vote_option":globals.vote_option,
            "option_context":globals.option_context,
            "vote_msg":globals.vote_msg,
            "vote_hash":globals.vote_hash,
        };
        $.ajax({method : "POST",
            url:globals.store_url,
            data:formdata,
            headers: { "X-CSRFToken": globals.csrf_token},
            dataType: 'json',

        }).done(function( msg ){
            if(msg.flag){
                var power= $.trim(msg.weight);
                $("#av-power").text(power+" Btc");
                $("#vote_sign").hide();
                $("#vote_success").show();
                $("#av-power").html(msg.weight + " btc");
                var all_weights = parseFloat(globals.all_weight) + parseFloat(msg.weight);
                if(all_weights <= 0 ){
                    all_weights = 1;
                }
                var new_op_weight = parseFloat(msg.weight)+ parseFloat(globals.option_weight);
                var percentage = Math.floor(new_op_weight/all_weights *10000)/100 + "%";
                var lenght = (Math.floor((new_op_weight/all_weights)*10000)/100 ==0 && $weight > 0) ? 1 : Math.floor((new_op_weight/all_weights)*10000)/100;
                $("#c-weight").css("width",lenght*775/100+"px");
                $("#c-bit").text(new_op_weight+"Btc");
                $("#c-percentage").text(percentage);
            }else{
                $(".v-error").html(msg.message);
            }
        });
    };

</script>
@endsection