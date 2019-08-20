$(document).ready(function () {
   //判断访问终端
   var browser = {
    versions: function () {
        var u = navigator.userAgent,
            app = navigator.appVersion;
        return {
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
            weixin: u.indexOf('MicroMessenger') > -1, //是否微信 （2015-01-22新增）
            qq: u.match(/\sQQ/i) == " qq" //是否QQ
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}
function is_weixin() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        return true;
    } else {
        return false;
    }
}

    var isWeixin = is_weixin();
    var winHeight = typeof window.innerHeight != 'undefined' ? window.innerHeight : document.documentElement.clientHeight;
    var jpg = isPIA() == 1 ? "./images/ios_tips.jpg" : "./images/android_tips.jpg";
    var bgcolor = isPIA() == 1 ? "rgb(24, 24, 24)" : "white";
    var winWidth = document.documentElement.clientWidth;
    var flag = winWidth > 414 ? 'none' : 'block';
    console.log(winWidth);
    var wheight = window.innerHeight;
    var weixinTip = $('<div id="weixinTip" style="display:'+flag+';z-index: 10000;position: absolute;top:9vh;right:9vw;background-color:'+bgcolor+' ;width:80px;height:80px;"><p><img id="tipimg" style="width:100%;height:100%;border:4px solid #fff;" src="' + jpg + '" alt=""/></p></div>');
    $("body").append(weixinTip); 
    //js判断终端是安卓还是苹果
    function isPIA() {
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isiOS) { return 1; }
        if (isAndroid) { return 2 };
    }
})