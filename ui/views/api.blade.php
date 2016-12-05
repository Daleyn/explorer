@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ $title }}</li>
                </ol>
            </div>

            <div class="row api">
                <div class="col-xs-12">
                    <div class="page-header">
                        <h1>{{ $title }}</h1>
                        <p class="api-header-desc">
{{--                            {{ trans('global.page.api.lastUpdatedAt', [ 'time' => date('Y-m-d H:i:s', filemtime(base_path("ui/docs/$lang.md"))) ]) }}--}}
                        </p>
                    </div>
                </div>

                <div class="col-xs-3 api-cat">
                    <div class="api-cat-inner" data-spy="affix"></div>
                </div>

                <div class="col-xs-9">
                    <div class="api-content markdown-body">
                        @include('apicontent-' . $lang)
                    </div>
                    {{--<div class="panel panel-primary api-feature-request">--}}
                        {{--<div class="panel-heading">{{ trans('global.page.api.featureRequestPanelTitle') }}</div>--}}
                        {{--<div class="panel-body">{!! trans('global.page.api.featureRequestPanelBody', ['link' => '#']) !!}</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

    @template
    <script type="text/template" id="api-cat">
        <div class="api-cat-inner">
            <ul class="api-cat-list api-cat-list-level-1">
                <% for (var i = 0; i < titles.length; i++) { %>
                <li class="api-cat-item">
                    <a href="#<%= titles[i].text %>"><%= titles[i].text %></a>

                    <% if (titles[i].children.length) { %>
                    <ul class="api-cat-list api-cat-list-level-2">
                        <% for (var j = 0; j < titles[i].children.length; j++) { %>
                            <li class="api-cat-item">
                                <a href="#<%= titles[i].children[j].text %>">
                                    <%= titles[i].children[j].text %>
                                </a>
                            </li>
                        <% } %>
                    </ul>
                    <% } %>
                </li>
                <% } %>
            </ul>
        </div>
    </script>
    @endtemplate

    @inlinescript
    <script>
        $(function() {
            var titles = [];

            //fix the hash
            $('.api-content [id]').each(function(i, el) {
                $(el).attr('id', $(el).text());
            });

            $('.api-content h2').each(function(i, el) {
                var $el = $(this);
                var children = $el.nextUntil('h2', 'h3').map(function(i, el) {
                    var $el = $(el);
                    return {
                        text: $el.text()
                    };
                });

                titles.push({
                    text: $(el).text(),
                    children: children
                });
            });

            var container = $('.api-cat-inner');
            var html = $(template('api-cat', {titles: titles}));
            container.html(html)
                    .affix({
                        offset: {
                            top: container.offset().top - 20,
                            bottom: 260
                        }
                    });
        });
    </script>
    @endinlinescript
@endsection