@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ trans('global.menu.stats') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="appIndex">
                    <div class="appIndex-inner">

                        <a class="appIndex-item" href="{{ route('stats.pool') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-poolShare"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-pool.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-pool.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.diff') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-diffTrend"></div>
                            <div class="appIndex-item-caption">{{ trans('global.page.stats-diff.title') }}</div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-diff.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.block.size') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-blockSize"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-block-size.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-block-size.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.fee') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-fee"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-fee.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-fee.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.block.ver') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-blockVer"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-block-ver.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-block-ver.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.richList') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-addressRichTop"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-rich-list.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-rich-list.description') }}</div>
                        </a>

                        <a class="appIndex-item" href="{{ route('stats.unconfirmedTxFees') }}">
                            <div class="appIndex-item-pic appIndex-item-pic-unconfirmedTx"></div>
                            <div class="appIndex-item-caption">
                                {{ trans('global.page.stats-unconfirmed-tx.title') }}
                            </div>
                            <div class="appIndex-item-desc">{{ trans('global.page.stats-unconfirmed-tx.description') }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection