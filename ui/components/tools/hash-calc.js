$(function () {

    /** 块收益*/
    function blockRewards(height) {
        return 50 / Math.pow(2, Math.floor(height / 210000));
    }

    /** 判断是否在同一个周期*/
    function inSameRewardPeriod(startHeight, endHeight, rewardHalvedStart) {
        return ~~(startHeight / rewardHalvedStart) == ~~(endHeight / rewardHalvedStart);
    }

    /** 理论起始高度*/
    function estimateStartHeight(todayHeight, startDate) {
        if (startDate.startOf('day').diff(moment().startOf('day'), 'day') == 0) return todayHeight;

        var remainMinutes = startDate.diff(moment(), 'minutes');
        return todayHeight + ~~(remainMinutes / 10);    //每十分钟出一个块
    }

    /** 周期秒数*/
    function estimatePeriodSecs(diffChange) {
        return 14 * 86400 / (1 + diffChange);
    }

    /** 不同周期理论全网算力*/
    function estimateNetworkHashRate(networkDiff) {
        return new Big(2016).times(new Big(2).pow(32)).times(new Big(networkDiff)).div(14 * 86400);
    }

    /** 计算器*/
    function calculate(config, customizeDiffChange, latestHeight, calculateLimit) {
        var hashRate = new Big(config.minerHashRate).times(1e9).times(config.minerCount); // 共有算力
        var electricityCostPerHour = new Big(config.minerCount).times(config.minerPower).div(1000).times(config.electricity); //每小时耗电量

        var startHeight = estimateStartHeight(latestHeight, moment(config.startDay));//起始高度
        var periodDiff = config.startDiff;  //本周难度

        var rows = [], endIndex = 0, flag = false,noProfitIndex=0;
        var totalProfitMoney = new Big(0);

        for (var iterDate = moment(config.startDay); rows.length <= calculateLimit;) {
            var endHeight = startHeight + 2016 - startHeight % 2016 - 1;    //结束高度
            var blockRewardHalvedStart = startHeight - startHeight % 210000; //本周期在某个周期(是否减半)内

            var currentPeriodSecsArray = [];
            var thisPeriodDiffChange = customizeDiffChange[rows.length] == null ? config.diffChange : customizeDiffChange[rows.length]; //本周期难度
            var periodDiffChange = customizeDiffChange[rows.length - 1] == null ? config.diffChange : customizeDiffChange[rows.length - 1]; //上周期难度
            var thisCurrentPeriodSecs = (endHeight - startHeight + 1) / 2016 * estimatePeriodSecs(periodDiffChange / 100); //本周期秒数

            if (moment.unix(iterDate.unix() + thisCurrentPeriodSecs) >= moment(config.endDay) && endIndex == 0) { //是否为最后一周期
                endIndex++;
                currentPeriodSecsArray.push(moment(config.endDay).unix() - iterDate.unix());
            }

            currentPeriodSecsArray.push(thisCurrentPeriodSecs);     //最后一周期秒数

            var currentIndex = 0;
            currentPeriodSecsArray.map(function (currentPeriodSecs) {

                currentIndex++;
                var electricityCostMoney = new Big(currentPeriodSecs).div(3600).times(electricityCostPerHour);//电费总额
                var row = {
                    periodStart: moment(iterDate),
                    periodEnd: moment.unix(iterDate.unix() + currentPeriodSecs),
                    networkDiff: estimateNetworkHashRate(periodDiff),
                    electricityCostMoney: electricityCostMoney,
                    electricityCostBTC: electricityCostMoney.div(config.BTCPrice),
                    diffChange: thisPeriodDiffChange
                };

                var incomeBTC, incomeMoney, profitMoney, noProfit = false, maxRow = false, endTime=false,noProfitRow=false;

                if (inSameRewardPeriod(startHeight, endHeight, blockRewardHalvedStart)) { //在同一周期(是否减半)内
                    incomeBTC = hashRate.times(currentPeriodSecs).div(new Big(2).pow(32).times(periodDiff))
                        .times(blockRewards(startHeight)).times(1 - config.poolFee / 100);
                    incomeMoney = incomeBTC.times(config.BTCPrice);
                    profitMoney = incomeMoney.minus(row.electricityCostMoney);
                } else {
                    var leftPeriodSecs = (blockRewardHalvedStart + 210000 - startHeight) / 2016 * currentPeriodSecs;
                    var rightPeriodSecs = currentPeriodSecs - leftPeriodSecs;

                    incomeBTC = hashRate.times(leftPeriodSecs).div(new Big(2).pow(32).times(periodDiff))
                        .times(blockRewards(startHeight)).times(1 - config.poolFee / 100)
                        .add(hashRate.times(rightPeriodSecs).div(new Big(2).pow(32).times(periodDiff))
                            .times(blockRewards(endHeight)).times(1 - config.poolFee / 100));
                    incomeMoney = incomeBTC.times(config.BTCPrice);
                    profitMoney = incomeMoney.minus(row.electricityCostMoney);
                }


                totalProfitMoney = totalProfitMoney.add(profitMoney);
                if (profitMoney.lte(0) && noProfitIndex==0){
                    noProfitIndex++
                    rows.length>1 ? rows[rows.length-1].noProfitRow=true : noProfitRow;
                }

                rows.length == calculateLimit ? maxRow = true : maxRow ; //最大200个周期
                profitMoney.lte(0) ? noProfit = true : noProfit;    // 无利润周期
                row.periodEnd.unix() > moment(config.endDay).unix() ? endTime=true : endTime; //超过结束日期周期

                _.extend(row, {
                    noProfit: noProfit,
                    noProfitRow:noProfitRow,
                    maxRow: maxRow,
                    endTime:endTime,
                    incomeBTC: incomeBTC,
                    incomeMoney: incomeMoney,
                    profitMoney: profitMoney,
                    profitBTC: profitMoney.div(config.BTCPrice),
                    totalProfitMoney: totalProfitMoney,
                    totalProfitBTC: totalProfitMoney.div(config.BTCPrice),
                    recoupPercent: totalProfitMoney.div(config.minerCount * config.minerPrice)
                });

                if (currentPeriodSecsArray.length == 2 ) {
                    if (currentIndex == 1) {
                        row.endTime=false;
                        rows.push(row);
                    } else {
                        row.endTime=true;
                        rows.push(row);
                        iterDate.add(currentPeriodSecs, 'seconds');
                    }
                }
                else {
                    rows.push(row);
                    iterDate.add(currentPeriodSecs, 'seconds');
                }

                if (profitMoney.lte(0)) {  //利润为0
                    if (endIndex==1) {   //到了结束日期
                        flag = true;
                    } else {
                        if (endIndex==1) { //未到结束日期
                            flag = true;
                        }
                    }
                }


            })

            if (flag) {
                break;
            }
            startHeight = endHeight + 1;
            periodDiff *= 1 + periodDiffChange / 100;

        }

        return rows;
    }

    Vue.config.debug = true;        // 生产环境中关闭
    Vue.config.delimiters = ['${', '}'];

    Vue.filter('tsToYmd', {
        read: function (v) {
            return moment(v).format('YYYY/MM/DD HH:mm');
        },
        write: function (v, oldVal) {
            return v;
        }
    });

    Vue.filter('toFixed', function (v, count) {
        if (count == null) count = 0;
        return v.toFixed(count);
    });

    Vue.filter('networkHashAndDiff', function (v) {
        var unit = ["", "k", "M", "G", "T", "P", "E", "Z", "Y"];
        var index = new Big(0);
        while (v >= 1000) {
            v = new Big(v).div(1000);
            index++;
        }
        return parseFloat(v).toFixed(2) + unit[index] + 'H/s';
    })

    var defaultConf = {
        'zh-cn': {
            startDay: moment(),
            endDay: moment().add(1, 'y'),
            currency: 'CNY',
            minerHashRate: 4730,
            minerPower: 1293,
            minerPrice: 3000,
            minerCount: 1,
            electricity: .2,
            BTCPrice: globals.exchangeRate.BTC2CNY,
            startDiff: globals.startDiff,
            diffChange: 2,
            poolFee: 1.5
        },
        'en': {
            startDay: moment(),
            endDay: moment().add(1, 'y'),
            currency: 'USD',
            minerHashRate: 4730,
            minerPower: 1293,
            minerPrice: 437,
            minerCount: 1,
            electricity: .03,
            BTCPrice: globals.exchangeRate.BTC2USD,
            startDiff: globals.startDiff,
            diffChange: 2,
            poolFee: 1.5
        }
    };

    new Vue({
        el: '.hashCalc',
        data: {
            loading: false,
            currencyMap: {
                USD: {
                    currency: 'USD',
                    symbol: '$'
                },
                CNY: {
                    currency: 'CNY',
                    symbol: '¥'
                }
            },
            customizeDiffChange: {},
            config: defaultConf[globals.lang] || defaultConf.en,
            result: {
                rows: [],

                totalProfit: new Big(0),
                totalIncome: new Big(0),
                totalElectricityCost: new Big(0),
                totalMinerCost: new Big(0),
                minerCostPerT: new Big(0),
                roi: new Big(0),
                currentPeriodIncomeMoneyPerDay: new Big(0),
                currentPeriodIncomeCostPerDay: new Big(0),
                currentPeriodIncomeProfitPerDay: new Big(0),
                daysToRecoup: new Big(-1),
                miningDays: new Big(0),
                maxMiningDays: new Big(0)
            },
            calculateLimit: 200
        },
        methods: {
            submitConfig: function (await) {
                var update = function () {
                    this.$data.loading = false;
                    this.$data.result.totalProfit=new Big(0);
                    this.$data.result.totalIncome=new Big(0);
                    this.$data.result.daysToRecoup=new Big(0);
                    this.$data.result.maxMiningDays==new Big(0);
                    this.$data.result.rows = rows;

                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].endTime) {
                            this.$data.result.totalProfit = rows[i-1].totalProfitMoney;  //总利润
                            break;
                        }else{
                            this.$data.result.totalIncome=this.$data.result.totalIncome.plus(rows[i].incomeMoney);  //总收入
                        }
                    }
                    this.$data.result.totalElectricityCost = new Big(this.$data.result.totalIncome).minus(this.$data.result.totalProfit); // 总电费
                    this.$data.result.totalMinerCost = new Big(this.$data.config.minerCount).times(this.$data.config.minerPrice); //总矿机成本
                    this.$data.result.minerCostPerT = new Big(this.$data.config.minerPrice).div(this.$data.config.minerHashRate).times(1000); //每 T 价格
                    this.$data.result.miningDays = moment(this.$data.config.endDay).diff(moment(this.$data.config.startDay), 'days', true);  //挖矿天数

                    this.$data.result.currentPeriodIncomeMoneyPerDay = rows[0].incomeMoney.div(rows[0].periodEnd.diff(rows[0].periodStart, 'days', true)); //当前每日收入
                    this.$data.result.currentPeriodIncomeCostPerDay = rows[0].electricityCostMoney.div(rows[0].periodEnd.diff(rows[0].periodStart, 'days', true));//当前每日电费
                    this.$data.result.currentPeriodIncomeProfitPerDay = this.$data.result.currentPeriodIncomeMoneyPerDay.minus(this.$data.result.currentPeriodIncomeCostPerDay) //当前每日利润
                    for (var m = 0; m < rows.length; m++) {
                        if (rows[m].totalProfitMoney.gte(this.$data.result.totalMinerCost)) {
                            this.$data.result.daysToRecoup = rows[m].periodEnd.diff(rows[0].periodStart, 'days', true); //回本天数
                            break;
                        }
                    }
                    for (var n = 0; n < rows.length; n++) {
                        if (rows[n].noProfit) {
                            this.$data.result.maxMiningDays = rows[n].periodStart.diff(moment(this.$data.config.startDay), 'days', true); //最多可挖天数
                            break;
                        }
                        if(rows[n].maxRow){
                            this.$data.result.maxMiningDays=new Big(-1);
                            break;
                        }
                    }
                    this.$data.result.roi =
                        this.$data.result.totalProfit.div(this.$data.result.totalMinerCost).times(100);   // 投资回报率



                }.bind(this);

                var customizeDiffChange = [];
                this.$data.result.rows.map(function (r) {
                    return customizeDiffChange.push(parseInt(r.diffChange));
                })

                var rows = calculate(this.$data.config, customizeDiffChange, globals.latestHeight, this.$data.calculateLimit);

                if (await) {
                    this.$data.loading = true;
                    setTimeout(update, 200);
                } else {
                    update();
                }

            },
            enableDate: function () {
                var startDate = moment($("#start-date").val()).add(1, 'days').format('YYYY/MM/DD HH:mm');
                $('#end-date').datetimepicker('setStartDate', startDate);
            },
            updateDiffChange: function () {
                this.$data.result.rows.map(function (row) {
                    row.diffChange = this.$data.config.diffChange;
                }.bind(this));
            }
        },
        ready: function () {
            // 初始化日历
            var startDate = moment($("#start-date").val()).add(1, 'days').format('YYYY/MM/DD HH:mm');

            $("#start-date").datetimepicker({
                format: 'yyyy/mm/dd hh:ii',
                todayBtn: true,
                todayHighlight: true,
                autoclose: true,
                //startView: 3,
                language: globals.lang == "zh-cn" ? "zh-CN" : "en",
            });

            $("#end-date").datetimepicker({
                format: 'yyyy/mm/dd hh:ii',
                startDate: startDate,
                todayHighlight: true,
                autoclose: true,
                //startView: 3,
                language: globals.lang == "zh-cn" ? "zh-CN" : "en",
            });

            this.submitConfig();

            this.$watch('config.startDay', this.enableDate); //结束日期小于开始日期
            this.$watch('config.diffChange', this.updateDiffChange); //结束日期小于开始日期
        }
    });

});