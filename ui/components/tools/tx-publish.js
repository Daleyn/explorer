/**
 * Created by ding on 11/19/15.
 */
$(function () {
    $('#broadcast-trade-btn').on('click', function () {
        var userMessage = $('#broadcast-trade-text').val();
        var showError = $('.show-error');
        $.ajax({
            url: globals.blockAPIEndpoint + 'tx/publish',
            type: "post",
            data: {
                "hex": userMessage
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    var html = "";
                    $('.broadcast-trade-content').attr('display', 'none');
                    html = html + "<div class='tx-publish-success'><h2>" + globals.trans.success.status + "</h2><p><a href ='/tx/" + data.success + "' target='_black'>" + globals.trans.success.view + "</a><a href style='margin-left: 20px;'>" + globals.trans.success.continue + "</a></p></div>";
                    $('.panel-body').html(html);
                } else {
                    $('#broadcast-trade-text').on("onchange",function(){
                    });
                    var msg = data.error.message.toLowerCase();
                    if (msg.indexOf('decode failed') > 0) {
                        data.error.code = 'InvalidHex';
                    } else {
                        data.error.code = 'TxPublishFailed';
                    }
                    showError.addClass('show').text(globals.trans.error[data.error.code] || data.error.code);
                }
            },
            statusCode: {
                422: function () {
                    var errorKey = "InvalidHex";
                    showError.addClass('show').text(globals.trans.error[errorKey] || errorKey);
                }
            }
        });
    });
});

function canSubmit(){
    var userMessage = $('#broadcast-trade-text').val();
    var showError = $('.show-error');
    showError.removeClass('show');
    if(userMessage == "") {
        $('#broadcast-trade-btn').attr('disabled',"disabled").css('cursor', 'not-allowed');
    } else {
        $('#broadcast-trade-btn').removeAttr('disabled').css('cursor','pointer');
    }
}