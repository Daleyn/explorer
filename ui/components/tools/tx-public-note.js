/**
 * Created by ding on 11/19/15.
 */
$(function() {
    $("#trade-hash-text").val("");
    $("#public-note").val("");
    $("#trade-note-text").val("");
    $("#autograph-text").text(globals.trans["message-placeholder"]);
    checkAddress();
    checkChangePubliceNote();
});
function checkHash() {
    var tradeHash = $.trim($('#trade-hash-text').val());
    var showError = $('.show-hash-error');
    var tradeNote = $('#trade-note');
    resetAutographInformation();
    $('#public-note').val("");
    if(tradeHash.length == 64){
        showError.css('display', 'block');
        showError.text(globals.trans.error.Verifying);
        $.get("/service/verifyTxHash/"+ tradeHash,function(data){
            var tradeAddress = $('#trade-address');
            var html = "";
            if (data.valid) {
                tradeNote.css('display', 'block');
                showError.css('display', 'none');
                tradeAddress.find("option").remove();
                for(var i = 0,len = data.addresses.length; i< len; i++ ){
                    html = html + "<option>" + data.addresses[i] + "</option>";
                }
                tradeAddress.append(html);
                tradeAddress.find("option").eq(0).attr("selected","selected");
            } else {
                tradeNote.css('display', 'none');
                showError.css('display', 'block');
                showError.text(globals.trans.error[data.code] || data.code);
            }
        },"json");
    } else {
        tradeNote.css('display', 'none');
        showError.css('display', 'block');
        showError.text(globals.trans.error.TxHashLengthError);
    }
    if(tradeHash == "") {
        showError.css('display', 'none');
        tradeNote.css('display', 'none');
    }
}

function checkAddress() {
    $("#trade-address").change(function() {
        resetAutographInformation();
        changeAutographText();
    });
}

function resetAutographInformation() {
    $('.show-error').css('display', 'none').removeClass("show");
    $('#autograph-text').text(globals.trans["message-placeholder"]);
    $('#trade-note-text').val("");
}

function checkChangePubliceNote() {
    $("#public-note").on("keyup",function() {
        $('#trade-note-text').val("");
    })
}
function canSubmit() {
    var publicNote = $('#public-note').val();
    var tradeNoteText = $('#trade-note-text').val();
    $('.show-error').css('display', 'none').removeClass("show");
    if(publicNote && tradeNoteText != "") {
        $('#trade-note-btn').removeAttr('disabled').css('cursor','pointer');
    } else {
        $('#trade-note-btn').attr('disabled','disabled').css('cursor','not-allowed');
    }
}

function submitForm() {
    var tradeHashText = $.trim($('#trade-hash-text').val());
    var tradeAddress = $('#trade-address').val();
    var publicNote = $('#public-note').val();
    var autographText = $('#autograph-text').text();
    var tradeNoteText = $('#trade-note-text').val();
    var showError = $('.show-error');
    $.ajax({
        url: "/service/addPublicNote",
        type: "post",
        data: {
            "txhash": tradeHashText,
            "address": tradeAddress,
            "message": autographText,
            "signature": tradeNoteText,
            "note": publicNote
        },
        headers: {
            'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
        },
        dataType: "json",
        success: function (data) {
            if (data.success) {
                var html = "";
                $('.trade-note').attr('display','none');
                html = html + "<div class='tx-publish-success'><h2>" + globals.trans.success + "</h2><p><a href ='/tx/" + tradeHashText + "' target='_black'>" + globals.trans["view-tx"] + "</a><a href style='margin-left: 20px;'>" + globals.trans.continue + "</a></p></div>";
                $('.panel-body').html(html);
            } else {
                showError.css('display','block').addClass("show").text(globals.trans.error[data.code] || data.code);
            }
        }
    });
}
function changeAutographText(){
    var publicNote = $.trim($('#public-note').val());
    if(publicNote == ""){
        $('#autograph-text').text(globals.trans["message-placeholder"]);
    } else {
        var nowDate = new Date();
        var autographText = publicNote + '.' +nowDate.getTime() + '.' + Math.floor(Math.random()*10000);
        $('#autograph-text').text(autographText);
    }
}