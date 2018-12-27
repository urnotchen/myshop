

<button id="share"></button>

<?php


    echo 4123;


$this->registerJs(<<<JS
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


