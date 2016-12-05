<!doctype html>
<html lang="{{ $lang }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">   
<title>{{ trans('global.page.wallet.title') }}</title>
<style>

    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 300;
        src:
        local('Roboto Light'),
        local('Roboto-Light'),
            /* from http://fonts.gstatic.com/s/roboto/v15/Hgo13k-tfSpn0qi1SFdUfT8E0i7KZn-EPnyo3HZu7kw.woff */
        url('/fonts/Roboto_300.woff') format('woff'),
            /* from http://fonts.gstatic.com/s/roboto/v15/Hgo13k-tfSpn0qi1SFdUfaCWcynf_cDxXwCLxiixG1c.ttf */
        url('/fonts/Roboto_300.ttf') format('truetype'),
            /* from http://fonts.gstatic.com/l/font?kit=Hgo13k-tfSpn0qi1SFdUfZbd9NUM7myrQQz30yPaGQ4&skey=11ce8ad5f54705ca#Roboto */
        url('/fonts/Roboto_300.svg#Roboto') format('svg');
    }

 body{
  background:#292F43  url(/wallet/images-mobile/iphone_bg.png)  center;
  background-repeat: no-repeat;
  background-size: 100% 100%;
  font-size: 16px;
  font-family: "Helvetica Neue",Helvetica,"Hiragino Sans GB","STHeitiSC-Light","Microsoft YaHei","微软雅黑",sans-serif;
 }
.main_body{

 }
.wallet_top{
  margin-top: 20px;
  width:270px;
  height: 75px;
  border:solid 0px red;

}

.wallet_logo{
   display: block;
   float: left;
  background-image: url(/wallet/images-mobile/btccom-logo-white.png);
  background-repeat: no-repeat;
  background-size: 110px auto;
  background-position: center top;
  height: 65px;
  width: 110px;
  margin-left: 75px;
}
.wallet_name{
  display: block;
  float: left;
  font-size: 28px;
  width:60px;
  color:white;
 margin-top:27px;
 margin-left:10px;
}
.phone_img{
  display: block;
  background-image: url(/wallet/images-mobile/perspective-screen-transparent.png);
  background-repeat: no-repeat;
  background-size: cover;
  height: 0px;
  width: 80%;
  padding-bottom: 26%;
}

.wallet_content{
  color:white;
  margin-top:10px;
  width:247px;
  font-size: 16px;
  line-height: 24px;
}
.downlow{
  width:96%;
  clear:both;
   height:60px;
  border:solid 0px red;
}
 .downlow a{
     text-decoration: none;
 }
 .downlow a:hover{
     text-decoration: none;
 }

 .downlow h2 {
     color: white;
 }

html[lang="ru"] .downlow .click-to-download {
    font-size: 11px;
    white-space: normal;
}
html[lang="ru"] .phonebtn {
    height: 50px;
}

html[lang="ja"] .downlow .click-to-download {
    font-size: 11px;
    white-space: normal;
}
html[lang="ja"] .phonebtn {
    height: 50px;
}

html[lang="de"] .downlow .click-to-download {
    font-size: 11px;
    white-space: normal;
}
html[lang="de"] .phonebtn {
    height: 50px;
}

html[lang="fr"] .downlow .click-to-download {
    font-size: 11px;
    white-space: normal;
}
html[lang="fr"] .phonebtn {
    height: 50px;
}

html[lang="tr"] .downlow .click-to-download {
    font-size: 11px;
    white-space: normal;
}
html[lang="tr"] .phonebtn {
    height: 50px;
}


.phonebtn{
 float:left;
 display: block;
 border-radius: 7px;
 width:47%;
 height:42px;
 font-size: 14px;
  text-align: left;
  margin-top: 12px;
}
.anzhuo{
    background-color: #3C78C3;
    border: solid 1px #3C78C3;
    cursor:pointer;
}
.ios{
   margin-left: 3%;
   background-color: #ABABAB;
   border: solid 1px #ABABAB;
}
.a_img{
   background-image: url(/wallet/images-mobile/iphone_icon_android_@2x.png) ;
   background-repeat: no-repeat;
   background-size: 24px auto;
   width:25px;
   height:25px;
   position: absolute;
   margin-left: 10px;
   margin-top: 8px;
   float: left;
}
.i_img{
   background-image: url(/wallet/images-mobile/iphone_icon_ios_@2x.png) ;
   background-repeat: no-repeat;
   background-size: 24px auto;
   width:25px;
   height:25px;
   position: absolute;
   margin-left: 10px;
   margin-top: 8px;
   float: left;
}
.down{
    border:solid 0px red;
    font-size:14px;
    white-space: nowrap;
    height:12px;
    color:white;
    line-height: 13px;
    width:108px;
    margin-left: 43px;
    margin-top:5px;
}
.code{
  margin-top:15px;
  clear:both;
  color:white;
  font-size:16px;
}
.code_img{
  margin-top: 10px;
   width:122px;
   height:122px;
   display: block;
   border:none;
   margin-bottom: 30px;
}
</style>
</head>
<body>
<center>
    <div class="main_body">
       <div class="wallet_top">  
             <span class="wallet_logo"></span>
             <span class="wallet_name">{{ trans('global.page.wallet.wallet') }}</span>
       </div>
       <div class="phone_img"></div>
       <div class="wallet_content">
          <span>{{ !$unavailable ? trans('global.page.wallet.desc') : trans('global.page.wallet.not_available_yet') }}</span>
       </div>
       @if(!$unavailable)
           <div class="downlow">
               @if($weixin)
                 <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.blocktrail.mywallet" class="phonebtn anzhuo">
               @else
                 <a href="/download/android" class="phonebtn anzhuo">
               @endif
                      <div class="a_img"></div>
                      <div style="float:left;">
                          <div class="down">{{ trans('global.page.wallet.android') }}</div>
                          <div class="down click-to-download">{{ trans('global.page.wallet.click-to-download') }}</div>
                      </div>
                 </a>

                 <a href="https://itunes.apple.com/us/app/blocktrail-bitcoin-wallet/id1019614423?mt=8" class="phonebtn ios">
                     <div class="i_img"></div>
                     <div style="float:left;">
                          <div class="down">{{ trans('global.page.wallet.ios') }}</div>
                          <div class="down click-to-download">{{ trans('global.page.wallet.click-to-download') }}</div>
                    </div>
                 </a>
          </div>
          <div class="code">
               <span>{{ trans('global.page.wallet.scan-qr-dl') }}</span>
               @if($weixin)
                 <img  class="code_img" src="/wallet/images-mobile/qr_weixin.png" />
               @else
                  <img  class="code_img" src="/wallet/images-mobile/qr.png" />
               @endif
          </div>
      @endif
    </div>
</center>
</body>
</html>
