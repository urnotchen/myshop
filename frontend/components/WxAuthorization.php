<?php

namespace frontend\components;

use frontend\models\FUser;
use frontend\models\UserToken;
use common\helpers\Curl;
use Yii;
use yii\base\Component;

class WxAuthorization extends Component {

    public $app_id;
    public $app_secret;
    public $scope;


    /*
     *  引入js-sdk的配置信息(签名等)
     * */
    public function actionIndex(){



        //获取基本access_token签名
        $access_token = Curl::httpGet("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::APP_ID."&secret=".self::APP_SECRET,true);
        $access_token = json_decode($access_token,true);
        $res = Curl::httpGet("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token['access_token']}&type=jsapi",true);
        $ticket = json_decode($res,true);

        $noncestr = 'Wm3WZYTPz0wzccnW';
        $jsapi_ticket = $ticket['ticket'];
        $timestamp = time();
        $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];

        $str = "jsapi_ticket={$jsapi_ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";
        $str_sha1 = sha1($str);
        return $this->render('index',[
            'app_id' => self::APP_ID,
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $str_sha1,
            'jsapi_ticket' => $jsapi_ticket,
//            'jsApiList' => json_encode(['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone']),
        ]);
    }

}