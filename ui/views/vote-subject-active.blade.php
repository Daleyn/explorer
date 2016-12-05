@extends('layout')
@script('/components/btcvote/clipboard.min.js')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        inputs_url: "{!! $inputs_url !!}",
        active_url: "{!! $active_url !!}",
        csrf_token: "{!! $csrf_token !!}",
        vote_hash: "{!! $vote_hash !!}",
        vote_md5: "{!! $vote_md5 !!}",
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
                    <li>{{ trans('global.page.vote-active.title') }} <span class="small-title">{{ trans('global.page.vote-active.title-comments') }}</span></li>
                </ol>
            </div>

            <div class="row v-row-left">
                <div id="active1" >
                    <div class="panel panel-bm" style="margin-bottom:10px;">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.page.vote-active.payment-title') }}</div>
                        </div>
                        <div class="panel-body">
                            <div class="v-active-paytitle">{{ trans('global.page.vote-active.payment-comments') }}</div>
                            <div class="v-active-code"><img width="165px" height="165px" src="https://walletapi.bitmain.com/v1/qr-code?msg=bitcoin:{{$income_address}}"></div>
                            <div class="v-active-codeNote"><a href="https://chain.btc.com/address/{{$income_address}}" target="_blank">{{$income_address}}</a></div>
                        </div>
                    </div>
                    <div class="panel panel-bm" >
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span>{{ trans('global.page.vote-active.verify-title') }}</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="v-active-table">
                                <tr>
                                    <td>
                                        <div class="v-active-title">{{trans('global.page.vote-active.first-title')}}</div>
                                        <div class="v-active-one" style="margin-top: 5px;">
                                            <input type="text" id="v-active-hash" onchange="get_inputs($(this))" style="width:750px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr id="pay-address" style="display: none;">
                                    <td>
                                        <div class="v-active-title">
                                            <span style="display: block;float:left;">{{trans('global.page.vote-active.inputs-title')}}</span>
                                            <span style="display: block;float:left; " class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-active.inputs-title-help')}}" ></span>
                                        </div><br/>
                                        <select class="v-action-select" id="v-action-select" onchange="changeForm()" style="margin-top: 5px;"></select>
                                        <a class="v-clip" id="v-clip" onclick="getval()"  data-clipboard-text=""  >{{trans('global.page.vote-active.inputs-copy')}}</a>
                                    </td>
                                </tr>
                                <tr id="pay-sign" style="display: none;">
                                    <td>
                                        <div class="v-active-title v-active-signtext">
                                            <span >{{trans('global.page.vote-active.second-title-one')}}</span>
                                            <input type="text" value="vote.btc.com/{{$vote_md5}}" class="v-active-sign" onclick="focus();select()">
                                            <span>{{trans('global.page.vote-active.second-title-two')}}</span>
                                        </div>
                                        <textarea id="v-active-signature"  style="width:750px;height:78px; margin-top: 5px;" onkeydown="$('#v-error').text('');"></textarea>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="error-msg" id="v-error"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <input id="vote-sub" type="button" class="btn" value="{{trans('global.page.vote-active.verify-button')}}" onclick="verifyAddress()">
                        <div class="v-others">
                            <div data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-active.verify-title-help')}}" >
                                <a href="{{$hash_url}}" target="_blank">{{trans('global.page.vote-active.tools-three')}}</a>
                                <span class="v-icon v-validation" ></span>
                            </div>
                            <div  data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-active.tools-two-help')}}" >
                                <span>{{trans('global.page.vote-active.tools-two')}}</span>
                                <span class="v-icon v-collection" ></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="active2" style="display: none;">
                    <div class="panel panel-bm">
                        <div class="panel-body" style="padding-left: 20px;">
                            <div class="v-as-title">{{trans('global.page.vote-active.verify-suc-title')}}</div>
                            <div class="v-as-info">
                               <div class="v-as-left">
                                   <span style="margin-top: 20px;">{{$vote_title}}</span>
                                   @if($vote_deadline <= 0)
                                   <span>{{trans('global.page.vote-active.vote-deadline-today')}}</span>
                                   @else
                                   <span>{{trans('global.page.vote-active.vote-deadline', ['days_num'=>$vote_deadline])}}</span>
                                   @endif
                               </div>
                               <div class="v-as-right"></div>
                            </div>
                        </div>
                        <div>
                            <div class="v-others" style="margin-left:190px ">
                                <div data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-active.verify-title-help')}}" >
                                    <a href="{{$hash_url}}" target="_blank">{{trans('global.page.vote-active.tools-three')}}</a>
                                    <span class="v-icon v-validation" ></span>
                                </div>
                                <div  data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-active.tools-two-help')}}" >
                                    <span>{{trans('global.page.vote-active.tools-two')}}</span>
                                    <span class="v-icon v-collection" ></span>
                                </div>
                                <div>
                                    <a href="{{$cast_url}}" target="_blank">{{trans('global.page.vote-active.tools-one')}}</a>
                                    <span class="v-icon v-go"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row v-row-right">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{trans('global.page.vote-workflow.workflow')}}</div>
                    </div>
                    <div class="panel-body">
                        <div class="v-flow">
                            <div class="flow-top flow-color"></div>
                            <div class="flow-second"></div>
                            <div class="flow-content flow-color">
                                <div class="f-left f-ok"></div>
                                <div class="f-right">
                                    <div>{{trans('global.page.vote-workflow.one')}}</div>
                                    <div>{{trans('global.page.vote-workflow.one-title')}}</div>
                                </div>
                            </div>
                            <div class="flow-line flow-color"></div>
                            <div class="flow-content flow-color">
                                <div class="f-left f-ok"></div>
                                <div class="f-right">
                                    <div>{{trans('global.page.vote-workflow.second')}}</div>
                                    <div>{{trans('global.page.vote-workflow.second-title')}}</div>
                                </div>
                            </div>
                            <div class="flow-line  flow-color"></div>
                            <div class="flow-content flow-color">
                                <div class="f-left" id="f3">3</div>
                                <div class="f-right">
                                    <div>{{trans('global.page.vote-workflow.third')}}</div>
                                    <div>{{trans('global.page.vote-workflow.third-title')}}</div>
                                </div>
                            </div>
                            <div class="flow-line" ></div>
                            <div class="flow-content">
                                <div class="f-left f-left-none" id="f4">4</div>
                                <div class="f-right" >
                                    <div>{{trans('global.page.vote-workflow.fourth')}}</div>
                                    <div>{{trans('global.page.vote-workflow.fourth-title')}}</div>
                                </div>
                            </div>
                            <div class="flow-line"></div>
                            <div class="flow-top"></div>
                            <div class="flow-mark">
                                {{trans('global.page.vote-workflow.comments')}}
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
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
        var clipboard = new Clipboard('.v-clip');
        clipboard.on('success', function(e) {
            e.clearSelection();
        });
    });
    function getval(){
        $("#v-clip").attr("data-clipboard-text",$("#v-action-select option:selected").text().trim());
        $("#v-clip").text(globals.trans['inputs-copy-suc']);
    }
   function changeForm(){
       $("#v-clip").text(globals.trans['inputs-copy']);
   }
    function get_inputs(obj){
        $("#v-error").html("");
        $("#v-clip").text(globals.trans['inputs-copy']);
        var tx_hash= obj.val().trim();
        var inputs_url = $.trim(globals.inputs_url +"/"+ encodeURIComponent(tx_hash));
        $.get(inputs_url, function(data, status){
            if(data.flag){
               var list=data.data;
               var html="";
                $.each(list,function(a,b){
                    html += "<option value="+b+">"+b+"</option>";
                });
                $("#pay-address").show();
                $("#pay-sign").show();
                $("#v-action-select").html(html);
            }else{
                $("#v-error").html(globals.trans['verify-failed'] +data.data);
            }
        });
    };
    function verifyAddress(){

        var address = $("#v-action-select option:selected").text().trim();
        var message = $.trim("vote.btc.com/"+globals.vote_md5);
        var signature = $.trim($("#v-active-signature").val());
        var vote_hash = $.trim(globals.vote_hash);
        var json_data={
            "_token":globals.csrf_token,
            "address":address,
            "message":message,
            "signature":signature,
            "vote_hash":vote_hash,
            "tx_hash":$("#v-active-hash").val().trim(),
        }
        $.ajax({
            method : "POST",
            url:globals.active_url,
            data:json_data,
            headers: { "X-CSRFToken": globals.csrf_token},
            dataType: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#v-error").html(globals.trans['signature-failed']);
            }
        }).done(function( msg ){
            if(msg.flag){
                $("#active1").hide();
                $("#active2").show();
                $(".small-title").remove();
                $("#f3").html("")
                $("#f3").addClass("f-ok")
                $("#f4").parent().prev().addClass("flow-color");
                $("#f4").parent().addClass("flow-color");
                $("#f4").removeClass("f-left-none");
                $("#f4").parent().next().addClass("flow-color");
                $("#f4").parent().next().next().addClass("flow-color");
            }else{
                $("#v-error").html(globals.trans['signature-failed']);
            }
        });
    }



</script>
@endsection
