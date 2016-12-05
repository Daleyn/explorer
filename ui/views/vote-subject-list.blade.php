@extends('layout')
@section('script_resource_prepend')@parent
<script type="text/javascript">
    var globals = {
        csrf_token: "{!! $csrf_token !!}",
        load_urls: {!! json_encode($load_urls) !!},
        search_url: {!! json_encode($search_url) !!},

    };
</script>
@endsection
@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{route('subject.list')}}"> {{ trans('global.menu.vote') }} </a></li>
                    <li id="v-list-theme">{{ trans('global.page.vote-list.title') }}</li>
                </ol>
            </div>
            <div class="row v-row-left">
                <div class="panel panel-bm">
                    <div class="panel-body">
                        <div>
                            <select id="v-st" class="v-list-select" onchange="direct()">
                                <option id="v_option_default">{{ trans('global.page.vote-list.default-sort') }}</option>
                                <option id="v_option_created_desc" <?= $selected == 'v_option_created_desc' ? ' selected="selected"' : '';?>>{{ trans('global.page.vote-list.latest-sort') }}</option>
                                <option id="v_option_created_asc" <?= $selected == 'v_option_created_asc' ? ' selected="selected"' : '';?>>{{ trans('global.page.vote-list.earliest-sort') }}</option>
                                <option id="v_option_hot" <?= $selected == 'v_option_hot' ? ' selected="selected"' : '';?>>{{ trans('global.page.vote-list.hot-sort') }}</option>
                                <option id="v_option_no_active" <?= $selected == 'v_option_no_active' ? ' selected="selected"' : '';?>>{{ trans('global.page.vote-list.unactivated-sort') }}</option>
                                <option id="v_option_done" <?= $selected == 'v_option_done' ? ' selected="selected"' : '';?>>{{ trans('global.page.vote-list.finished-sort') }}</option>
                            </select>
                            <div class="v-list-search-div">
                                <input id="v-list-context" type="text"
                                       placeholder={{ trans('global.page.vote-list.search-placeholder') }} class="v-list-search"/>
                                <span class="v-search-button" onclick="search()"></span>
                            </div>
                        </div>
                        <div class="v-list">

                            @foreach($vote_list as $vote)
                            <a class="v-item" href="{{ route('subject.show', ['key' => $vote['vote_hash']]) }}" target="_blank">
                                @if($vote['status'] == 'wait_payment')
                                    <div class="unactive"></div>
                                    <span class="item-title">{{$vote['title']}}</span>
                                @elseif(in_array($vote['status'],['done', 'complete']))
                                    <div class="end"></div>
                                    <span class="item-title">{{$vote['title']}}</span>
                                @else
                                    <div></div>
                                    <span class="item-title">{{$vote['title']}}</span>
                                @endif
                                @if(in_array($vote['status'],['wait_payment', 'active']))
                                    @if(intval((strtotime($vote['vote_deadline']) - time()) / 86400) <=0)
                                        <span>{{trans('global.page.vote-list.vote-deadline-today')}}</span>
                                    @elseif(intval((strtotime($vote['vote_deadline']) - time()) / 86400) ==1)
                                        <span>{{trans('global.page.vote-list.vote-deadline-one-today')}}</span>
                                    @else
                                        <span>{{trans('global.page.vote-list.vote-deadline', ['days_num' => intval((strtotime($vote['vote_deadline']) - time()) / 86400)])}}</span>
                                    @endif
                                @endif
                                @if(in_array($vote['status'],['active', 'done', 'complete']))
                                    @if($vote['all_count'] <= 1)
                                        <span>{{trans('global.page.vote-list.weight-title-one', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                    @else
                                        <span>{{trans('global.page.vote-list.weight-title', ['weight' => $vote['all_weight'], 'count'=>$vote['all_count']])}}</span>
                                    @endif
                                @endif
                            </a>
                            @endforeach
                        </div>
                        <div class="page-nav" style="margin-top: 20px;">
                            @if($start > 0)
                                <?php  $url_keys['start'] = $start-10>=0 ?$start-10 : 0 ?>
                                <a class="page-navPrev text-hide" href="{{ route('subject.list', $url_keys)}}"></a>
                            @endif
                            @if($remaining_num >0)
                                <?php  $url_keys['start'] = $start+10?>
                                <a class="page-navNext text-hide" href="{{ route('subject.list', $url_keys) }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row v-row-right">
                <div class="panel panel-bm">
                    <div class="panel-body">
                       <div class="list-create">
                           <a class="create-vote" href="{{ route('subject.create') }}" target="_blank">
                              {{ trans('global.page.vote-list.create-button') }}
                           </a>
                       </div>
                        <div class="list-express">{{ trans('global.page.vote-list.comments') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 @section("script_resource_inline")@parent
  <script>

      function search() {
          var context= $("#v-list-context").val().trim();
          window.location.href=globals.search_url+context;
      }
     function direct(){
        var st= $("#v-st").children(":selected").attr('id');
         var url = globals.load_urls[st];
         window.location.href=globals.load_urls[st];
     }
  </script>
@endsection
