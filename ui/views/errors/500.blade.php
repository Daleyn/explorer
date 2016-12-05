<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>500 Sever Error</title>
    <link rel="stylesheet" href="/style/http500.less"/>
</head>
<body>

<div class="container">
    <div class="container-inner">
        <div class="heading">
            <!-- remove -->
            <span class="reqid">{{ session('request-id') }}</span>
            <!-- /remove -->
            <div class="img-container">
                <img src="/images/500@3x.png" alt="500" width="101" height="107">
            </div>
            <h1> Server Error </h1>
        </div>

        <div class="content">
            <p class="en">An error occurred, our engineers are fixing it, please try again later.</p>
            <p class="zh-cn">服务器遇到错误。我们的工程师正在解决，请稍候再试。</p>
        </div>
    </div>
</div>

</body>
</html>
