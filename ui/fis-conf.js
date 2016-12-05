var format = require('util').format;
var moment = require('moment');
var execSync = require('child_process').execSync;
var marked = require('marked');
var fs = require('fs');

var DOMAIN = process.env.DOMAIN || 'https://btcstatic.oss-cn-hangzhou.aliyuncs.com/explorer';

var uglify = fis.plugin('uglify-js', {
    compress : {
        drop_console: true
    }
});

function bladeProcessor(content, file, conf) {
    var re = /(?:@script\(('|")(.*)(?:\1)\)(?:\s*))|(?:@style\(('|")(.*)(?:\3)\)(?:\s*))|@inlinescript\b\s*(<script\b[^>]*>[\S\s]*?<\/script>)\s*@endinlinescript\b(?:\s*)|@template\b\s*([\S\s+]*?)\s*@endtemplate\b(?:\s*)/ig;

    var scriptArr = [],
    scriptPlaceHolder = '@{__scriptPlaceHolder__}',
    scriptPlaceHolderAdded = false,
    inlineScriptArr = [],
    inlineScriptPlaceHolder = '@{__inlineScriptPlaceHolder__}',
    inlineScriptPlaceHolderAdded = false,
    styleArr = [],
    stylePlaceHolder = '@{__stylePlaceHolder__}',
    stylePlaceHolderAdded = false,
    tplArr = [],
    tplPlaceHolder = '@{__tplPlaceHolder__}',
    tplPlaceHOlderAdded = false;

    content = content.replace(re, function(m, _, script, __, style, inlineScript, template) {
        var ret = '';

        if (script) {
            scriptArr.push(fis.compile.lang.id.wrap('"' + script + '"'));
            if (!scriptPlaceHolderAdded) {
                ret += scriptPlaceHolder;
                scriptPlaceHolderAdded = true;
            }
        }

        if (inlineScript) {
            inlineScriptArr.push(inlineScript);
            if (!inlineScriptPlaceHolderAdded) {
                ret += inlineScriptPlaceHolder;
                inlineScriptPlaceHolderAdded = true;
            }
        }

        if (style) {
            styleArr.push(fis.compile.lang.id.wrap('"' + style + '"'));
            if (!stylePlaceHolderAdded) {
                ret += stylePlaceHolder;
                stylePlaceHolderAdded = true;
            }
        }

        if (template) {
            tplArr.push(template);
            if (!tplPlaceHOlderAdded) {
                ret += tplPlaceHolder;
                tplPlaceHOlderAdded = true;
            }
        }

        return ret;
    });

    return content
        .replace('@{__scriptPlaceHolder__}', function() {
            return ['@section("script_resource")@parent', scriptArr.map(function(id) {
                return '{!! script(' + id + ') !!}';
            }).join(''), '@endsection\n'].join('');
        })
        .replace('@{__inlineScriptPlaceHolder__}', function() {
            return ['@section("script_resource_inline")@parent', inlineScriptArr.map(function(s) {
                return s.trim();
            }).join(''), '@endsection\n'].join('');
        })
        .replace('@{__stylePlaceHolder__}', function() {
            return ['@section("style_resource")@parent', styleArr.map(function(id) {
                return '{!! style(' + id + ') !!}';
            }).join(''), '@endsection\n'].join('');
        })
        .replace('@{__tplPlaceHolder__}', function() {
            return ['@section("template")@parent', tplArr.map(function(tpl) {
                return tpl.trim();
            }).join(''), '@endsection\n'].join('');
        });
}

fis.set('project.ignore', ['node_modules/**', 'output/**', 'fis-conf.js', 'package.json', 'scripts/**']);

fis
    .match('::package', {
        spriter: fis.plugin('csssprites')
    })
    .match('*', {
        release: '/public/assets$0',
        url: '/assets$0'
    })

    // vendor js
    .match('/node_modules/**.js', {
        release: '/public/assets$0',
        url: '/assets$0'
    })

    // less
    .match('/style/*.less', {
        parser: fis.plugin('less'),
        rExt: '.css',
        release: '/public/assets$0',
        url: '/assets$0',
        useSprite: true
    })
    .match('/style/{bootstrap,module,module_mobile}/**', {
        useMap: false
    })

    // templates
    .match('/views/**', {
        release: '/resources$0'
    })

    .match('*.blade.php', {
        preprocessor: bladeProcessor,
        isHtmlLike: true
    })

    .match('/views/errors/500.blade.php', {
        //发布 blade 模板到 ../public/500.html
        postprocessor: function(content) {
            var re = /<!-- remove -->[\s\S]*?<!-- \/remove -->/g;
            fs.writeFileSync(__dirname + '/../public/500.html', content.replace(re, ''));
            return content;
        }
    })

    .match('/opensearch.xml', {
        release: '/public/assets$0',
        domain: DOMAIN,
        preprocessor: function(content) {
            return content.replace(/(<ns0:Image[^>]*?>)(.+?)(<\/ns0:Image>)/, function(_, open, iconUrl, close) {
                return open + fis.compile.lang.uri.wrap(iconUrl) + close;
            });
        }
    });

fis.media('prod')
    .match('/images/**.png', {
        optimizer: fis.plugin('png-compressor')
    })
    .match('*.{png,jpg,gif,eot,svg,ttf,woff,woff2}', {
        useHash: true,
        domain: DOMAIN
    })
    .match('*.js', {
        useHash: true,
        optimizer: uglify,
        domain: DOMAIN
    })
    .match('/node_modules/**.js', {
        packTo: 'vendor.js'
    })
    .match('/style/*.less', {
        useHash: true,
        optimizer: fis.plugin('clean-css'),
        domain: DOMAIN,
        useSprite: true
    })
    .match('/wallet/style/wallet.css', {
        useHash: true,
        optimizer: fis.plugin('clean-css'),
        domain: DOMAIN,
        useSprite: true
    })
    .match('layout.blade.php', {
        postprocessor: function(content, file, info) {
            var createdAt = moment.utc();
            return content.replace('<!-- VERSION -->',
                format('<!-- Version: %s, Build at: %s. -->',
                    execSync('git rev-parse HEAD', {encoding: 'utf8'}).trim(),
                    createdAt.format('dddd, MMMM Do YYYY, h:mm:ss a')
                )
            );
        }
    })
    .match('*.blade.php:js', {
        optimizer: uglify
    })
    .match('*.blade.php:css', {
        optimizer: fis.plugin('clean-css')
    })

    .match('/opensearch.xml', {
        useHash: true
    });
