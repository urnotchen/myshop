<?php

namespace frontend\controllers;

use common\helpers\Curl;
use frontend\models\FUser;
use frontend\models\UserToken;
use yii\web\Controller;

class WxController extends Controller{

    const SCOPE = 'snsapi_userinfo';
    const REDIRECT_URI = 'http://39.108.230.44/index.php';
    const APP_ID = 'wxb7ba89d49cdacf6b';
    const APP_SECRET = '7f06ea2e6c9465b0d67a4d2855a756b1';

    /*
     * 微信请求授权
     * */
    public function actionPermmitWx(){

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::APP_ID.'&redirect_uri='.urlencode(self::REDIRECT_URI).'&response_type=code&scope='.self::SCOPE.'&state=STATE#wechat_redirect';

        $this->redirect($url);
    }

    /*
     * 获取微信code
     *http://39.108.230.44/index.php?code=021iwtz60a4S5E1xGRx60aS9z60iwtzl&state=123
     * */

    public function actionGetCode($code){

        $output = Curl::httpGet('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.self::APP_ID.'&secret='.self::APP_SECRET.'&code='.$code.'&grant_type=authorization_code',true);
        $json = json_decode($output,true);
        
//        var_dump($json['access_token']);die;
//        $json = new \stdClass();
//        $json->access_token = "17_lr-TOIP_2cnec3eoEf7t29XN_yM80RLtH1lmTfBWYxwlFKlXFrwqQ2rY7u0xlJGpmzJD0-gozZhcQl8Qp18FJA" ;
//        $json->expires_in = 7200;
//        $json->refresh_token = "17_JboOK99SOrizyGXt-9nuFY5ejWgZa2cCmfCHLC2FHMKzCGLRu5FqSp2_KKKVIbkabmqnkXzlNOKXqEE1c5dYzw" ;
//        $json->openid = "oIzMq0imQsGjutk9w9951YzStyG0";
        //拉取下用户信息
        $userinfo = Curl::httpGet("https://api.weixin.qq.com/sns/userinfo?access_token={$json['access_token']}&openid={$json['openid']}&lang=zh_CN",true);
        //保存token
        $transaction = \Yii::$app->db->beginTransaction();
        try {

            if ($userinfo) {
                $userinfo = json_decode($userinfo, true);
                $user = FUser::updateUser($json['openid'], $userinfo);
            } else {
                $user = FUser::updateUser($json['openid']);
            }
//            var_dump($user);
//            die;
            UserToken::updateToken($user->id, $json['openid'], $json['access_token'], $json['expires_in'], $json['refresh_token']);
        }catch (\Exception $e) {
            var_dump($e->getMessage());
            $transaction->rollback();
//            throw new HttpException(403,'数据库错误',ResponseCode::DATABASE_SAVE_FAILED);
        }
        $transaction->commit();
    }

    public function actionIndex(){

        return $this->render('index');
    }
}
?>

