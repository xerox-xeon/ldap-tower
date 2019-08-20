var pIdData = {
    "www.dwqp355.com":"19818634",
    "www.dwqp366.com":"49178762",
    "www.dwqp377.com":"65955978",
    "www.dwqp388.com":"57567370",
    "www.dwqp399.com":"24012938",
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
