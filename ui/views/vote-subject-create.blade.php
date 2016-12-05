@extends('layout')
@script('/components/btcvote/adddate.js')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        active_url: "{!! $active_url !!}",
        store_url: "{!! $store_url !!}",
        csrf_token: "{!! $csrf_token !!}",
        lang: "{!! $lang!!}",
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
                    <li>{{ trans('global.page.vote-create.title') }}  <span class="small-title">{{ trans('global.page.vote-create.title-comments') }}</span></li>
                </ol>
            </div>


            <div class="row v-row-left">
                <div id="C1">
                    <div class="panel panel-bm" style="margin-bottom:10px;">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.page.vote-create.subject-title') }}</div>
                        </div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <span>{{ trans('global.page.vote-create.subject') }}</span>
                                            <span class="v-star">*</span>
                                        </div>
                                        <div>
                                            <input id="title" type="text" maxlength="100" onkeyup="showlimit($(this),100);"  >
                                            <span class="limit">100</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <span>{{trans('global.page.vote-create.subject-promoter')}}</span>
                                            <span class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-create.vote-creator-help')}}"></span>
                                        </div>
                                        <div>
                                            <input id="sponsor" type="text"  maxlength="30"  onkeyup="showlimit($(this),30);">
                                            <span  class="limit">30</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <span>{{trans('global.page.vote-create.subject-comments')}}</span>
                                        </div>
                                        <div>
                                            <input id="note" type="text" maxlength="500"  onkeyup="showlimit($(this),500);">
                                            <span class="limit">500</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <span>{{trans('global.page.vote-create.subject-deadline')}}</span>
                                            <span class="v-star">*</span>
                                            <span class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-create.vote-deadline-help')}}" ></span>
                                        </div>
                                        <div>
                                            <input id="date-d" type="text" class="datepicker1" data-placement="bottom"  data-provide="datepicker"  readonly="readonly" onchange="limitTime()" style="width: 215px !important;">
                                            <span  class="error-time"></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-bm">
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span>{{trans('global.page.vote-create.options-title')}}</span>
                                <span class="v-title-star">*</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="vote-p">
                                <tr>
                                    <td>
                                        <input type="text" maxlength="80" onkeyup="showlimit($(this),80);">
                                        <span class="limit">80</span>
                                        <span class="v-del" onclick="deloption($(this))"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" maxlength="80" onkeyup="showlimit($(this),80);">
                                        <span class="limit">80</span>
                                        <span class="v-del" onclick="deloption($(this))"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="v-add-op" onclick="addoption()">
                                            <div class="v-add-op-icon" >
                                                <span class="v-icon-1">+</span>
                                                <span class="v-icon-2">{{trans('global.page.vote-create.options-add')}}</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <input id="v-btn-sub" type="button" class="btn"  value="{{trans('global.page.vote-create.next-button')}}&nbsp;&nbsp;>" onclick="nextC2()">
                    </div>
                </div>
                <div id="C2">
                    <div class="panel panel-bm" style="margin-bottom:10px;">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{trans('global.page.vote-create.subject-show-title')}}</div>
                        </div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <span id="from-title" class="c-title"></span>
                                        </div>
                                        <div class="title c-time">
                                            <div>
                                                <span>{{trans('global.page.vote-create.subject-deadline')}}</span>
                                                <span id="from-deadline"></span>
                                                <span>UTC</span>&nbsp;
                                                <span class="v-help" data-toggle="tooltip" data-placement="bottom" title="{{trans('global.page.vote-create.vote-deadline-help')}}" style="height:16px;"></span>
                                                <span class="pormat">
                                                    <span id="from-sponsor"></span>
                                                    <span>{{trans('global.page.vote-create.subject-promoter')}}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-bm">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{trans('global.page.vote-create.subject-show-options')}}</div>
                        </div>
                        <div class="panel-body" >
                            <div id="c-op">
                            </div>
                            <div class="v-ck">
                                <input type="checkbox" id="readconfirm" onclick="duty()"/>
                                <span  class="v-Words "onclick="$('#readconfirm').click();" >{{trans('global.page.vote-create.confirm-define')}}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input id="create" type="button" class="btn submit-unchecked"  value="{{trans('global.page.vote-create.next-button')}}&nbsp;&nbsp;>" onclick="create()">
                        <a class="back" onclick="back()">{{trans('global.page.vote-create.last-button')}}</a>
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
                           <div class="flow-content flow-color" id="fc1">
                               <div class="f-left" id="f1">1</div>
                               <div class="f-right">
                                    <div>{{trans('global.page.vote-workflow.one')}}</div>
                                    <div>{{trans('global.page.vote-workflow.one-title')}}</div>
                               </div>
                           </div>
                           <div class="flow-line flow-color"></div>
                           <div class="flow-content" id="fc2">
                               <div class="f-left f-left-none" id="f2">2</div>
                               <div class="f-right">
                                   <div>{{trans('global.page.vote-workflow.second')}}</div>
                                   <div>{{trans('global.page.vote-workflow.second-title')}}</div>
                               </div>
                           </div>
                           <div class="flow-line"></div>
                           <div class="flow-content">
                               <div class="f-left f-left-none">3</div>
                               <div class="f-right">
                                   <div>{{trans('global.page.vote-workflow.third')}}</div>
                                   <div>{{trans('global.page.vote-workflow.third-title')}}</div>
                               </div>
                           </div>
                           <div class="flow-line"></div>
                           <div class="flow-content">
                               <div class="f-left f-left-none">4</div>
                               <div class="f-right">
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
        if ($("#readconfirm").is(':checked')) {
            $("#create").removeClass("submit-unchecked");
            $('#create').removeAttr("disabled");
        }
        for(var i=0; i<=23;i++){
            var h=i;
            if(i<=9){
                h="0"+i;
            }
        }

        $('.datepicker1').datepicker({
            format: 'yyyy-mm-dd',
            startDate: GetDateStr(2),
            autoclose: true,
            todayHighlight:true,
            startView:'year',
//            minView:"days",
            language: globals.lang=="zh-cn" ? "zh-CN" :"en",
            keyboardNavigation:true,
            pickerPosition: 'bottom-left',
        });
        $(".error-time").html("");
    });

    var deloption=function(obj){
        if($("#vote-p tr").length!=3){
            obj.parent().parent().remove();
        }
    }
    var addoption=function(){
        if($("#vote-p tr").length<11){
            $("#vote-p tr:last").before('<tr><td><input type="text" maxlength="80" onkeyup="showlimit($(this),80)"> <span class="limit">80</span><span class="v-del" onclick="deloption($(this))"></span></td></tr>');
        }
    }
    var showlimit=function(obj,num){
        if(obj.next().next().hasClass("v-error")){
            obj.next().next().remove();
        }
        if(obj.attr("maxlength","80")){
            if(obj.next().next().next().hasClass("v-error")){
                obj.next().next().next().remove();
            }
        }

        var count=obj[0].value.length;
        if(count<=num){
            obj.next().removeClass("limitWords")
            obj.next().text(num-count);
            if(num-count==0){
                obj.next().addClass("limitWords")
            }
        }
    }
    var optionsArray;
    var nextC2=function(){
        var flag=true;
        var num=0;optionEmpty=0, optionsArray=[];
        var ops={1:"A",2:"B",3:"C",4:"D",5:"E",6:"F",7:"G",8:"H",9:"I",10:"J"}
        $(".v-error").remove();
        if($.trim($("#title").val())==""){
            $("#title").next().after("<span class='v-error'>"+globals.trans['vote-subject-error']+"</span>");
            return false;
        }
        if($.trim($("#date-d").val())==""){
            $(".error-time").text(globals.trans['vote-subject-error']);
            return false;
        }
        var booltime=limitTime();
        if(booltime==false){
            return false;
        }
        $('#vote-p input').each(function(){
            num++;
            var value=$.trim($(this).val());
            if($.trim($(this).val())==""){
                $(this).next().next().after('<span class="v-error">'+globals.trans['vote-subject-error']+'</span>');
                flag=false;
            }
            optionsArray.push($(this).val());
            $("#c-op").append('<div class="c-panel"> <span>'+ops[num]+'</span> <span>'+$.trim($(this).val())+'</span></div>')
        })
        var deadline= $.trim($("#date-d").val()) +" "+"00:00:00"
        if(flag==false){
            $("#c-op").html("");
            return false;
        }
        $("#from-title").text($.trim($("#title").val()))
        $("#from-sponsor").text($.trim($("#sponsor").val()))
        $("#from-context").text($.trim($("#note").val()))
        $("#from-deadline").text(deadline);
        back("C2");
    }

    var create=function(){
        var title= $.trim($("#from-title").text());
        var sponsor=$.trim($("#from-sponsor").text());
        var note=$.trim($("#note").val());
        var deadline=$.trim($("#from-deadline").text());

        var formdata={
            "_token":globals.csrf_token,
            "title":title,
            "promoter":sponsor,
            "context":note,
            "options":optionsArray,
            "vote_deadline":deadline,
        }
        $.ajax({method : "POST",
            url:globals.store_url,
            data:formdata,
            headers: { "X-CSRFToken": globals.csrf_token},
            dataType: 'json',
        }).done(function( msg ){
            if(msg.flag){
                window.location.href=globals.active_url+"/" + msg.hash;
            }else{
                $("#v-title-created").show();
            }
        });
    };

    var duty = function () {
        if ($("#readconfirm").is(':checked')) {
            $("#create").removeClass("submit-unchecked");
            $('#create').removeAttr("disabled");
        }else{
            $("#create").addClass("submit-unchecked");
            $('#create').attr("disabled","disabled");
        }
    }
    var  back=function(type){
        if(type=="C2"){
            $("#C1").hide();
            $("#C2").show();
            $(".small-title").text(globals.trans['title-show-comments']);
            $("#f1").html("");
            $("#f1").addClass("f-ok");
            $("#fc2").addClass("flow-color");
            $("#f2").removeClass("f-left-none");
        }else{
            $("#c-op").html("");
            $("#C2").hide();
            $("#C1").show();
            $(".small-title").text(globals.trans['title-comments']);
            $("#f1").html("1");
            $("#f1").removeClass("f-ok");
            $("#fc2").removeClass("flow-color");
            $("#f2").addClass("f-left-none");
        }
    }
    function limitTime(){
        var bool=false;
        var today = Date.now() / 1000;
        var tomorrow = today - (today % 86400) + 2*86400;
        var next_year = tomorrow + 86400*364;
        var deadline = new Date($.trim($("#date-d").val())+"T"+"00:00:59Z").getTime() / 1000;
        if(tomorrow>=deadline){
            $(".error-time").text(globals.trans['deadline-error-one']);
            return false;
        }
        if(deadline>=next_year){
            $(".error-time").text(globals.trans['deadline-error-two']);
            return false;
        }else{
            $(".error-time").text("");
            bool=true;
        }
        return bool;
    }

    function GetDateStr(AddDayCount) {
        var dd = new Date();
        dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;//获取当前月份的日期
        var d = dd.getDate();
        return y+"-"+m+"-"+d;
    }


</script>
@endsection









