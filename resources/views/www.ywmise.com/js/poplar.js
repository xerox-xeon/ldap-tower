var pIdData = {
    "www.dwqp533.com":"09332874",
    "www.dwqp566.com":"51275914",
    "www.dwqp577.com":"21915786",
    "www.dwqp588.com":"36202634",
    "www.dwqp622.com":"52979850",
} 
function G(n) {
    var e = window.location.search.substr(1).match(new RegExp("(^|&)" + n + "=([^&]*)(&|$)"));
    return null != e ? unescape(e[2]) : null
}
var b = document.getElementsByClassName("mohe_down");
    var e = OpenInstall.parseUrlParams();
    let I = pIdData[window.location.hostname]==undefined ? null : pIdData[window.location.hostname];
    e.pId = G("pId") || I
    new OpenInstall({
        appKey:'mcisvt',
        onready: function() {
            var n = this;
            for (var e = 0; e < b.length; e++)
                b[e].onclick = function() {
                    n.schemeWakeup()
                    n.wakeupOrInstall()
                }
        }
    },e)
