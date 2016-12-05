@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ trans('global.menu.tools') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="appIndex">
                    <div class="appIndex-inner">

                        <a class="appIndex-item" href="{{ route('tools.publish') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-txPublish"></div>
                            <div class="appIndex-item-caption">{{ trans('global.page.tool-publish.title') }}</div>
                            <div class="appIndex-item-desc">{{ trans('global.page.tool-publish.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('tools.note') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-txNotes"></div>
                            <div class="appIndex-item-caption">{{ trans('global.page.tx-public-note.title') }}</div>
                            <div class="appIndex-item-desc">{{ trans('global.page.tx-public-note.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('tools.calc') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-hashCalc"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.tool-mining-calc.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.tool-mining-calc.description') }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection