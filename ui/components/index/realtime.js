$(function() {
    // 工具函数
    // copy from https://github.com/taijinlee/humanize/blob/master/humanize.js

    /**
     * format number by adding thousands separaters and significant digits while rounding
     */
    function numberFormat(number, decimals, decPoint, thousandsSep) {
        decimals = isNaN(decimals) ? 2 : Math.abs(decimals);
        decPoint = (decPoint === undefined) ? '.' : decPoint;
        thousandsSep = (thousandsSep === undefined) ? ',' : thousandsSep;

        var sign = number < 0 ? '-' : '';
        number = Math.abs(+number || 0);

        var intPart = parseInt(number.toFixed(decimals), 10) + '';
        var j = intPart.length > 3 ? intPart.length % 3 : 0;

        return sign + (j ? intPart.substr(0, j) + thousandsSep : '') + intPart.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousandsSep) + (decimals ? decPoint + Math.abs(number - intPart).toFixed(decimals).slice(2) : '');
    }

    function blockVersionFormat(ver) {
        if (ver < 16) {
            return ver;
        }

        // 转成 二进制 并补成32位， 判定BIP9 支持情况
        var ver2bin = parseInt(ver, 10).toString(2);
        while(ver2bin.length < 32) {
            ver2bin = "0" + ver2bin;
        }
        var ver2binArray = ver2bin.split("");

        if (ver2binArray[2] == 1) {
            if (ver2binArray[3] == 1 && ver2binArray[31] == 1) {
                return [68, 109];
            }

            if (ver2binArray[3] == 1) {
                return [109];
            }

            if (ver2binArray[31] == 1) {
                return ["68 / 112 / 113"];
            }

            if (ver2binArray[30] == 1) {
                return ["SegWit"];
            }

            return [9];
        } else {
            return 'Other';
        }
    }

    /**
     * Formats the value like a 'human-readable' number (i.e. '13 K', '4.1 M', '102', etc).
     *
     * For example:
     * If value is 123456789, the output would be 117.7 M.
     */
    function intword(number, units, kilo, decimals, decPoint, thousandsSep, suffixSep) {
        var humanized, unit;

        units = units || ['', 'K', 'M', 'G', 'T'],
            unit = units.length - 1,
            kilo = kilo || 1000,
            decimals = isNaN(decimals) ? 2 : Math.abs(decimals),
            decPoint = decPoint || '.',
            thousandsSep = thousandsSep || ',',
            suffixSep = suffixSep || '';

        for (var i=0; i < units.length; i++) {
            if (number < Math.pow(kilo, i+1)) {
                unit = i;
                break;
            }
        }
        humanized = number / Math.pow(kilo, unit);

        var suffix = units[unit] ? suffixSep + units[unit] : '';
        return numberFormat(humanized, decimals, decPoint, thousandsSep) + suffix;
    }

    /**
     * Formats the value like a 'human-readable' file size (i.e. '13 KB', '4.1 MB', '102 bytes', etc).
     *
     * For example:
     * If value is 123456789, the output would be 117.7 MB.
     */
    function sizeFormat(filesize, kilo, decimals, decPoint, thousandsSep, suffixSep) {
        kilo = (kilo === undefined) ? 1024 : kilo;
        if (filesize <= 0) { return '0 bytes'; }
        if (filesize < kilo && decimals === undefined) { decimals = 0; }
        if (suffixSep === undefined) { suffixSep = ' '; }
        return intword(filesize, ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB'], kilo, decimals, decPoint, thousandsSep, suffixSep);
    }

    /**
     * @param {string} poolName
     * @return {string}
     */
    function pool2classname(poolName) {
        var name = poolName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
        return globals.poolclasses.some(function(c) {
            return c == name;
        }) ? name : 'unknown';
    }

    function animateChange(startValue, toValue, duration, fps, setter, done) {
        var start = Date.now();
        var timer = null;

        (function loop() {
            var now = Date.now();
            if (now - start >= duration) {
                return setter(toValue);
            }

            setter(startValue + (now - start) / duration * (toValue - startValue));

            timer = setTimeout(loop, duration / fps);
        })();
    }

    function toRelativeTime(timestamp) {
        var now = Date.now();
        var diff = now - timestamp;
        var d = moment.utc(diff);
        var h = d.hour(),
            m = d.minute(),
            ret = '';
        var hUnit = globals.lang == 'zh-cn' ? '小时' : 'hour';
        var hUnitPlural = globals.lang == 'zh-cn' ? '小时' : 'hours';
        var mUnit = globals.lang == 'zh-cn' ? '分钟前' : 'minute ago';
        var mUnitPlural = globals.lang == 'zh-cn' ? '分钟前' : 'minutes ago';
        var rightnow = globals.lang == 'zh-cn' ? '刚刚' : 'right now';

        if (globals.lang == 'ru') {
            hUnit = 'ч';
            hUnitPlural = 'ч';
            mUnit = 'м назад';
            mUnitPlural = 'м назад';
            rightnow = 'сейчас';
        } else if (globals.lang == 'ja') {
            hUnit = '時間';
            hUnitPlural = '時間';
            mUnit = '分前に';
            mUnitPlural = '分前に';
            rightnow = 'いますぐ';
        } else if (globals.lang == 'de') {
            hUnit = 'Stunde';
            hUnitPlural = 'Stunden';
            mUnit = 'Minute vor';
            mUnitPlural = 'Minuten vor';
            rightnow = 'jetzt gerade';
        } else if (globals.lang == 'fr') {
            hUnit = 'heure';
            hUnitPlural = 'heures';
            mUnit = 'minute ago';
            mUnitPlural = 'minutes ago';
            rightnow = 'tout de suite';
        } else if (globals.lang == 'tr') {
            hUnit = 'saat';
            hUnitPlural = 'saat';
            mUnit = 'minute ago';
            mUnitPlural = 'minutes ago';
            rightnow = 'şu an';
        } else if (globals.lang == 'es') {
            hUnit = 'hora';
            hUnitPlural = 'horas';
            mUnit = 'minute ago';
            mUnitPlural = 'minutes ago';
            rightnow = 'ahora';
        } else if (globals.lang == 'bg') {
            hUnit = 'ч';
            hUnitPlural = 'ч';
            mUnit = 'м назад';
            mUnitPlural = 'м назад';
            rightnow = 'в момента';
        } else if (globals.lang == 'cs') {
            hUnit = 'hodina';
            hUnitPlural = 'hodiny';
            mUnit = 'před minutou';
            mUnitPlural = 'před minutami';
            rightnow = 'právě teď';
        } else if (globals.lang == 'ko') {
            hUnit = '시간';
            hUnitPlural = '시간';
            mUnit = '분전';
            mUnitPlural = '분전';
            rightnow = '지금';
        } else if (globals.lang == 'da') {
            hUnit = 'time';
            hUnitPlural = 'timer';
            mUnit = 'minute ago';
            mUnitPlural = 'minutes ago';
            rightnow = 'lige nu';
        } else if (globals.lang == 'el') {
            hUnit = 'ώρα';
            hUnitPlural = 'ώρες';
            mUnit = 'minute ago';
            mUnitPlural = 'minutes ago';
            rightnow = 'τώρα';
        }

        if (diff >= 86400 * 1000) { //大于一天
            return moment.utc(timestamp).format('YYYY/MM/DD HH:mm');
        }

        if (diff >= 3600 * 1000) {  //大于一个小时
            ret += h + ' ' + (h > 1 ? hUnitPlural : hUnit);
            if (m < 10) m = '0' + m;
            ret += ' ' + m + ' ' + (m > 1 ? mUnitPlural : mUnit);
            return ret;
        }

        if (diff >= 60 * 1000) {    //大于 1 分钟
            ret += m + ' ' + (m > 1 ? mUnitPlural : mUnit);
            return ret;
        }

        return rightnow;
    }

    function renderTx(cnt, size) {
        animateChange(lastCount, cnt, animationDuration, fps, function(v) {
            txCount.textContent = numberFormat(v, 0);
        });
        lastCount = cnt;

        animateChange(lastSize, size, animationDuration, fps, function(v) {
            txSize.textContent = numberFormat(v, 0);
            txSizeHuman.textContent = sizeFormat(v, 0);
        });
        lastSize = size;
    }

    function renderBlock(newBlocks, expiredBlocks) {
        // remove expired blocks
        $.when.apply($, expiredBlocks.map(function(blk) {
            var $el = $('.indexBlockList tr[data-id="' + blk.block_id + '"]');
            return $el.fadeOut(300).promise()
                .then(function() {
                    return $el.remove();
                });
        })).then(function() {   // all removed
            $('.indexBlockList tr').slice(1).remove();
            $('#append').after(blockTpl({
                blocks: newBlocks.map(prepareBlock)
            }));
        });
    }

    function prepareBlock(blk) {
        return {
            height: numberFormat(blk.height, 0),
            heightLink: blk.height,
            poolName: blk.extras.pool_name,
            txCount: numberFormat(blk.tx_count, 0),
            version: blockVersionFormat(blk.version),
            size: numberFormat(blk.size, 0),
            reward: numberFormat((blk.reward_block + blk.reward_fees) / 1e8, 8),
            classname: pool2classname(blk.extras.pool_name),
            timestamp: blk.timestamp,
            time: toRelativeTime(blk.timestamp * 1000),
            hash: blk.hash
        };
    }

    function newBlocksHandler (newBlocks) {
        // find out expired blocks
        var expired = lastBlocks.filter(function(blk) {
            return !newBlocks.some(function(nblk) {
                return nblk.hash == blk.hash;
            });
        });

        lastBlocks = newBlocks;

        renderBlock(newBlocks, expired);
    }

    var socket = io(globals.socketEndpoint);
    var animationDuration = 1000;
    var fps = 25;

    var txSize = document.querySelector('.tx-size'),
        txSizeHuman = document.querySelector('.tx-size-human'),
        txCount = document.querySelector('.tx-count');
    var lastSize = +globals.tx.size, lastCount = +globals.tx.cnt, lastBlocks = globals.blocks;
    var blockTpl = template(__inline('/components/index/block_tpl.html'));

    socket.on('tx', function(tx) {
        console.log('new tx', tx);

        if (tx.cnt == lastCount) return;

        renderTx(tx.cnt, tx.size);
    });

    socket.on('blocks', function(newBlocks) {
        console.log('new block', newBlocks);
        newBlocksHandler(newBlocks);
    });

    // 每分钟更新时间
    setInterval(function() {
        console.log('interval rendered');
        newBlocksHandler(lastBlocks);
    }, 60 * 1000);
});