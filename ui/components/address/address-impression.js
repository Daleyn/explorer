/**
 * Created by ding on 11/19/15.
 */
$(function(){
    showCurrentImpression();
    makeEvaluationImpression();
    addImpression();
    addVoteValue();
    getMoreImpression();
});

function showCurrentImpression() {
    var impressionContent = $('.address-impression-body');
    var currentImpression = globals.impressions;
    if (currentImpression.length !== 0) {
        var current = "<ul class='clearfix'></ul>";
        impressionContent.append(current);
        addCurrentImpression(impressionContent);
    }
}

function addCurrentImpression(impressionContent){
    var impressionParents = impressionContent.find("ul");
    var html = "";
    for(var i = 0;i < globals.impressions.length; i++) {
        html = html + '<li class="address-impression-item"> <a href="#"><span class="address-impression-item-content">' + globals.impressions[i].key + '</span><span class="address-impression-item-upvotes">' + globals.impressions[i].count + '</span></a></li>';
        impressionParents.append(html);
        html = ""
    }
}

function makeEvaluationImpression() {
    var impressionUl = $(".address-impression-body ul");
    if(impressionUl.length !== 0){
        impressionUl.find("li").each(function () {
            var upVotes = $(this).find('.address-impression-item-upvotes');
            var currentValueNum = $(this).find('.address-impression-item-upvotes').text();
            var currentValue = $(this).find('.address-impression-item-content').text();
            var i = 0;
            $(this).click(function () {
                if (i == 0) {
                    $.post("/service/impression",
                        {
                            "address": globals.address,
                            "taglang": globals.lang,
                            "impression": currentValue
                        },
                        function(data){
                            if(data.success) {
                                currentValueNum++;
                                upVotes.text(currentValueNum);
                            }
                        });
                }
                if (i >= 1) {
                    alert(globals.trans.impression.error.voted);
                }
                i++;
            });
        });
    }
}

function addImpression() {
    var impressionCreation = $('.address-impression-creation');
    impressionCreation.on('click', 'a', function () {
        impressionCreation.html('<form action="#" onsubmit="return false;"> <input type="text" class="address-impression-create-input" name="im" autofocus="autofocus" autocomplete="off" maxlength="41" onkeyup="checkValue();"> <button class="btn btn-primary btn-bm address-impression-create-submit" onclick="createImpression();">'+ globals.trans.impression.submit +'</button></form>');
        $('input.address-impression-create-input').focus();
    });
}

function checkValue(){
    var createImpressionValue = $.trim($('.address-impression-create-input').val());
    var createSubmitBtn = $('.address-impression-create-submit');
    if(createImpressionValue.length == 41) {
        alert(globals.trans.impression.error.toLongChars || "tooLong");
        createSubmitBtn.attr('disabled','disabled').css('cursor','not-allowed');
    } else {
        createSubmitBtn.removeAttr('disabled').css('cursor','pointer');
    }
}

function createImpression() {
    var createImpressionValue = $.trim($('.address-impression-create-input').val());
    if (createImpressionValue == "") {
        $('.address-impression-creation').html('<a href="#" class="address-impression-create"> <i class="icon-address-impression-create"></i>' + globals.trans.impression.create + '</a>');
    } else {
        var ImpressionParents = $('.address-impression-body ul');
        var current = "" ;
        if(ImpressionParents.length === 0){
            current = current + "<ul class='clearfix'></ul>";
            $('.address-impression-body').append(current);
            addNewImpression(createImpressionValue);
        } else {
            addNewImpression(createImpressionValue);
        }
    }
}

function addNewImpression(createImpressionValue){
    var ImpressionParents = $('.address-impression-body ul');
    var newImpressionNum = 1;
    var newImpression = "";
    var impression_more = $('.address-impression-item-more');
    impression_more.css('display', 'none');
    impression_more.nextAll().css('display', 'block');
    newImpression = newImpression + '<li class="address-impression-item" onclick="newMakeEvaluationImpression()"> <a href="#"><span class="address-impression-item-content">' + createImpressionValue + '</span><span class="address-impression-item-upvotes">' + newImpressionNum + '</span></a></li>';
    ImpressionParents.append(newImpression);
    $('.address-impression-creation').html('<a href="#" class="address-impression-create"> <i class="icon-address-impression-create"></i>' + globals.trans.impression.create + '</a>');
    sendImpression(createImpressionValue);
}

function sendImpression(createImpressionValue) {
    $.post("/service/impression",
        {
            "address": globals.address,
            "impression": createImpressionValue,
            "taglang": globals.lang
        }, function (data) {
            if (!data.success) {
                alert(globals.trans.error.networkError || "添加失败！")
            }
        }, "json");
}

function newMakeEvaluationImpression() {
    alert(globals.trans.impression.error.voted);
}

function addVoteValue(){
    $('.address-impression-vote-up').find("span").text(globals.upvote);
    $('.address-impression-vote-down').find("span").text(globals.downvote);
}

function makeEvaluation(item) {
    var upValue = $('.address-impression-vote-up').find("span");
    var downValue = $('.address-impression-vote-down').find("span");
    var upNum = upValue.text();
    var downNum = downValue.text();

    if (globals.voted) {
        alert(globals.trans.impression.error.voted);
    } else {
        if (item == 'up') {
            $.ajax('/service/vote', {
                method: 'POST',
                data: {
                    vote: item + 'vote',
                    address: globals.address
                },
                headers: {
                    'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
                },
                success: function () {
                    upNum++;
                    globals.voted = "true";
                    upValue.text(upNum);
                }
            });
        } else {
            $.ajax('/service/vote', {
                method: 'POST',
                data: {
                    vote: item + 'vote',
                    address: globals.address
                },
                headers: {
                    'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
                },
                success: function () {
                    downNum++;
                    globals.voted = "true";
                    downValue.text(downNum);
                }
            });
        }
    }

}

function getMoreImpression() {
    var getMore = $(".address-impression-body ul");
    var currentImpressionNum = $('.address-impression-item');
    if(currentImpressionNum.length >= 10){
        var html = '<li class="address-impression-item-more"> <a href="javascript:" class="address-impression-more"> <i class="icon-address-impression-more"></i></a></li>';
        currentImpressionNum.eq(9).nextAll().css('display','none');
        getMore.append(html);
    }
    var impressionMore = $('.address-impression-item-more');
    impressionMore.on('click',function() {
        currentImpressionNum.eq(9).nextAll().css('display','block');
        impressionMore.css('display','none');
    })
}
