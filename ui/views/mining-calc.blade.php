@extends('layout')
@script('/components/tools/datetimepicker/bootstrap-datetimepicker.js')
@script('/components/tools/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js')
@script('/components/tools/hash-calc.js')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        blockAPIEndpoint: {!! json_encode($endpoint) !!},
        lang: {!! json_encode($lang) !!},
        startDiff: {!! json_encode($startDiff) !!},
        latestHeight: {{ $latestHeight }},
        exchangeRate: {!! json_encode($exchangeRate) !!}
    };
</script>
@endsection

@section('style_resource_inline')@parent
<style>
    .affix {
        top: 10px;
    }

    .affix-bottom {
        position: absolute;
    }

    [v-cloak] {
        visibility: hidden;
    }
</style>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('tools') }}">{{ trans('global.menu.tools') }}</a></li>
                    <li>{{ trans('global.page.tool-mining-calc.title') }}</li>
                </ol>
            </div>
            <div class="row">
                <div class="hashCalc" v-cloak>
                    <div class="panel panel-bm">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.page.tool-mining-calc.title') }}</div>
                        </div>
                        <div class="panel-body">
                            <div class="hashCalc-config-wrapper">
                                <div class="hashCalc-config">
                                    <form @submit.prevent="submitConfig">
                                        <table>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.currency') }}</th>
                                                <td>
                                                    <select class="form-control" v-model="config.currency">
                                                        <option v-for="currencyInfo in currencyMap"
                                                                :value="currencyInfo.currency">
                                                            ${ currencyInfo.currency + ' - ' + currencyInfo.symbol }
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.miner-cost') }}</th>
                                                <td>
                                                    <input type="number" class="form-control" min="1" step="1" required
                                                           v-model="config.minerPrice">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.miner-count') }}</th>
                                                <td>
                                                    <input type="number" class="form-control" min="1" step="1" required
                                                           v-model="config.minerCount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.miner-hashrate') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                               required v-model="config.minerHashRate"
                                                               title="{{ trans('global.page.tool-mining-calc.config.enter-positive-integer') }}"
                                                               pattern="^[1-9]\d*$"
                                                        >
                                                        <div class="input-group-addon">GH/s</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.miner-power') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" min="1" step="1"
                                                               required v-model="config.minerPower">
                                                        <div class="input-group-addon">W</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.electricity') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" min="0" step=".01"
                                                               required v-model="config.electricity">
                                                        <div class="input-group-addon">
                                                            ${currencyMap[config.currency].symbol}/KWh
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="table-sep">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.btc-price') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" min="1" step=".01"
                                                               required v-model="config.BTCPrice">
                                                        <div class="input-group-addon">
                                                            ${currencyMap[config.currency].symbol}/BTC
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.start-diff') }}</th>
                                                <td>
                                                    <input type="text" class="form-control" v-model="config.startDiff">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.diff-change') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" max="99" min="-99"
                                                               step=".01" required v-model="config.diffChange">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.pool-fee') }}</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" min="0" max="10"
                                                               step=".01" required v-model="config.poolFee">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="hashCalc-poolfeetip">
                                                    <a href="javascript:" @click="config.poolFee = 1.5">BTC.COM 1.5%</a>
                                                    /
                                                    <a href="javascript:" @click="config.poolFee = 2">BTCC 2%</a>  /
                                                    <a href="javascript:" @click="config.poolFee = 3">F2Pool 3%</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.start-date') }}</th>
                                                <td>
                                                    <input type="text" class="form-control form_datetime"
                                                           id="start-date"
                                                           readonly v-model="config.startDay | tsToYmd"
                                                    >
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('global.page.tool-mining-calc.config.end-date') }}</th>
                                                <td>
                                                    <input type="text" class="form-control form_datetime" id="end-date"
                                                           readonly v-model="config.endDay | tsToYmd">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="table-sep">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="clearfix">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-large hashCalc-config-submit">{{ trans('global.page.tool-mining-calc.config.calculate') }}</button>
                                                    </div>
                                                    <p class="text-muted"
                                                       style="font-size: 12px; margin-top: 20px; line-height: 1.4; color: #888;">
                                                        {{ trans('global.page.tool-mining-calc.config.note') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>

                            <div class="hashCalc-estimate">
                                <div class="loading" v-show="loading"></div>
                                <div class="hashCalc-estimate-caption">
                                    {{ trans('global.page.tool-mining-calc.estimate.caption') }}
                                </div>
                                <div class="hashCalc-estimate-summary">
                                    <table>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.total-profit') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${currencyMap[config.currency].symbol} ${result.totalProfit | toFixed 2}
                                            </td>

                                            <th style="padding-left: 10px;">{{ trans('global.page.tool-mining-calc.estimate.current-daily-devenue') }}</th>
                                            <td>${currencyMap[config.currency].symbol}
                                                ${result.currentPeriodIncomeMoneyPerDay | toFixed 2 }
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.total-revenue') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${currencyMap[config.currency].symbol} ${result.totalIncome | toFixed 2}
                                            </td>

                                            <th style="padding-left: 10px;">{{ trans('global.page.tool-mining-calc.estimate.current-daily-electricity-costs') }}</th>
                                            <td>${currencyMap[config.currency].symbol}
                                                ${result.currentPeriodIncomeCostPerDay | toFixed 2 }
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.total-electricity') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${currencyMap[config.currency].symbol}
                                                ${result.totalElectricityCost | toFixed 2}
                                            </td>

                                            <th style="padding-left: 10px;">{{ trans('global.page.tool-mining-calc.estimate.current-Daily-profit') }}</th>
                                            <td>${currencyMap[config.currency].symbol}
                                                ${result.currentPeriodIncomeProfitPerDay | toFixed 2 }
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.total-miner-costs') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${currencyMap[config.currency].symbol}
                                                ${result.totalMinerCost | toFixed 2}
                                            </td>

                                            <th style="padding-left: 10px;">{{ trans('global.page.tool-mining-calc.estimate.days-to-payback') }}</th>
                                            <td v-if="result.daysToRecoup>0">${result.daysToRecoup | toFixed 0 }</td>
                                            <td v-else>{{ trans('global.page.tool-mining-calc.estimate.cannot-payback') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.revenue-per-th') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${currencyMap[config.currency].symbol}
                                                ${result.minerCostPerT | toFixed 2 }
                                            </td>

                                            <th style="padding-left: 10px;">{{ trans('global.page.tool-mining-calc.estimate.mining-days') }}</th>
                                            <td>${result.miningDays | toFixed 0 }</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('global.page.tool-mining-calc.estimate.return-on-investment') }}</th>
                                            <td style="border-right: 1px solid #eee; padding-right: 10px;">
                                                ${result.roi | toFixed 2} %
                                            </td>

                                            <th style="padding-left: 10px;" style="min-width:240px!important">{{ trans('global.page.tool-mining-calc.estimate.maximum-mining-mays') }}</th>
                                            <td v-if="result.maxMiningDays>=0" >${result.maxMiningDays | toFixed 0 }</td>
                                            <td v-else>{{ trans('global.page.tool-mining-calc.estimate.all-mining') }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <hr>

                                <div class="hashCalc-estimate-detail">
                                    <table>
                                        <tr>
                                            {{--<th class="text-center">{{ trans('global.page.tool-mining-calc.estimate.period') }}</th>--}}
                                            <th class="text-center">{{ trans('global.page.tool-mining-calc.config.start-date') }}</th>
                                            <th class="text-right" style="max-width: 70px;">{{ trans('global.page.tool-mining-calc.estimate.network-hashrate') }}</th>
                                            <th class="text-right">{!! trans('global.page.tool-mining-calc.estimate.period-revenue') !!}</th>
                                            <th class="text-right">{!! trans('global.page.tool-mining-calc.estimate.period-electricity') !!}</th>
                                            <th class="text-right">{!! trans('global.page.tool-mining-calc.estimate.period-profit') !!}</th>
                                            <th class="text-right">{!! trans('global.page.tool-mining-calc.estimate.period-total-profit') !!}</th>
                                            <th class="text-right"  style="max-width: 70px;">{{ trans('global.page.tool-mining-calc.estimate.payback-progress') }}</th>
                                            <th class="text-right"  style="max-width: 70px;">{{ trans('global.page.tool-mining-calc.estimate.difficulty-change') }}</th>
                                        </tr>
                                        <tbody v-for="el in result.rows" track-by="$index">
                                        <tr v-bind:style="el.noProfit ? 'color:red' : ''" v-if="el.endTime==false">
                                            {{--<td style="text-align: center">${ $index+1 }</td>--}}
                                            <td class="text-center">
                                                <div>${ el.periodStart.format('YY/MM/DD HH:mm') }</div>
                                                <div>${ el.periodEnd.format('YY/MM/DD HH:mm') }</div>
                                            </td>

                                            <td class="text-right">
                                                ${ el.networkDiff | networkHashAndDiff }
                                            </td>

                                            <td class="text-right">
                                                <div style="white-space: nowrap">฿ ${ el.incomeBTC.toFixed(8) }</div>
                                                <div>
                                                    ${currencyMap[config.currency].symbol} ${el.incomeMoney.toFixed(2) }
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                <div style="white-space: nowrap">
                                                    ฿ ${ el.electricityCostBTC.toFixed(8)}
                                                </div>
                                                <div>
                                                    ${currencyMap[config.currency].symbol}
                                                    ${el.electricityCostMoney.toFixed(2) }
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                <div style="white-space: nowrap">฿ ${ el.profitBTC.toFixed(8) }</div>
                                                <div>
                                                    ${currencyMap[config.currency].symbol} ${ el.profitMoney.toFixed(2)}
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                <div style="white-space: nowrap">฿ ${ el.totalProfitBTC.toFixed(8) }</div>
                                                <div>
                                                    ${currencyMap[config.currency].symbol}
                                                    ${el.totalProfitMoney.toFixed(2)}
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                ${ el.recoupPercent.times(100).toFixed(2) } %
                                            </td>

                                            <td class="text-right">
                                                <input type="number" max="100" min="-100" style="width:35px;text-align: center"
                                                       v-model="el.diffChange"
                                                       @keyup.enter="submitConfig"
                                                >%
                                            </td>
                                        </tr>
                                        <tr v-if="el.noProfitRow && el.endTime==false">
                                            <td colspan="9">
                                            <span>
                                                {{ trans('global.page.tool-mining-calc.estimate.tip-no-profit') }}
                                            </span>
                                            </td>
                                        </tr>
                                        <tr v-if="el.maxRow && el.endTime==false">
                                            <td colspan="9">
                                            <span>
                                                {{ trans('global.page.tool-mining-calc.estimate.tip-reach-limit') }}
                                            </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@inlinescript
<script>
    $(function () {
        if ($(document.body).width() >= 1180) {
            var $config = $('.hashCalc-config');
            $config.affix({
                offset: {
                    top: $config.offset().top - 10,
                    bottom: 260
                }
            });
        }
    });

</script>
@endinlinescript