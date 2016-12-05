#!/bin/bash

set -e

ROOT=$(cd "$(dirname "$0")"/../..; pwd)
PATH="$ROOT"/ui/node_modules/.bin:$PATH

# ENDPOINT 变量替换
ENDPOINT=https://chain.api.btc.com/v3

LANGS=(zh-cn en ru ja de fr tr es pt bg cs ko da el)
FALLBACK_LANG=en

for LANG in ${LANGS[@]}; do
    URL=https://raw.githubusercontent.com/btccom/ExplorerAPIDoc/master/doc."$LANG".md

    markdown=`curl -s -f "$URL" | sed 's=${ENDPOINT}='"$ENDPOINT"'=g'` || true # set -e 要求所有的语句执行结果为真

    if [ -z "$markdown" ]; then # 若 curl 执行失败,则 markdown 为空
        echo "$LANG not found, fallback default lang $FALLBACK_LANG"

        URL=https://raw.githubusercontent.com/btccom/ExplorerAPIDoc/master/doc."$FALLBACK_LANG".md
        markdown=`curl -s -f "$URL" | sed 's=${ENDPOINT}='"$ENDPOINT"'=g'` || true # set -e 要求所有的语句执行结果为真

    fi

    output="$ROOT"/resources/views/apicontent-"$LANG".blade.php

    marked <<<"$markdown" > "$output"

    echo "$LANG parsed: $output"


done