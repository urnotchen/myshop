

<button id="share"></button>

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
        link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: '', // 分享图标
        success: function () {
          // 设置成功
        }
});});
    
$("#share").on('click',share);
function share(){
    alert(123);
   wx.scanQRCode({
needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
success: function (res) {
var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
}
});
}
JS
);


