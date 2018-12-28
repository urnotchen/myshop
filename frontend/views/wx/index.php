

<button id="share"></button>
<form>
    <input type="hidden" id="app_id" value=<?php echo $app_id?> />
    <input type="hidden" id="timestamp" value=<?php echo $timestamp?> />
    <input type="hidden" id="nonceStr" value=<?php echo $nonceStr?> />
    <input type="hidden" id="signature" value=<?php echo $signature?> />
    <input type="hidden" id="jsapi_ticket" value=<?php echo $jsapi_ticket?> />
</form>
<?php


$this->registerJs(<<<JS
console.log(location.href.split('#')[0]);
    var app_id = $("#app_id").val();
    var signature = $("#signature").val();
    var timestamp = $("#timestamp").val();
    var nonceStr = $("#nonceStr").val();
 
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: app_id, // 必填，公众号的唯一标识
        timestamp: timestamp, // 必填，生成签名的时间戳
        nonceStr: nonceStr, // 必填，生成签名的随机串
        signature : signature,
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
    wx.updateTimelineShareData({ 
        title: '分享abc', // 分享标题
        link: 'http://39.108.230.44/iii.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: 'http://mmbiz.qpic.cn/mmbiz_jpg/qCbSKFcQyqJ1PcvFlAvIYGib1RvoEEbaESyAV3ibseWrsOjoBoxOdeScNwz0QcAgWD12HSeFV5VT6vovibmCunKLw/0', // 分享图标
        success: function () {
          // 设置成功
          console.log('设置成功123');
        }
});});
    
$("#share").on('click',share);
function share(){
 wx.updateAppMessageShareData({ 
        title: '你好分享', // 分享标题
        desc: '测试分享描述', // 分享描述
        link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: '', // 分享图标
        success: function () {
          // 设置成功
        }});
}
JS
);


