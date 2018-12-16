<?php

namespace frontend\components\rest;

use Yii;
use frontend\modules\v1\models\forms\AccessTokenForm;

/**
 * AccessTokenLogin class file.
 * @Author haoliang
 * @Date 11.01.2016 18:34
 *
 * 貌似并未使用
 */
class AccessTokenLogin extends \yii\base\ActionFilter
{

    public $accessTokenKey = 'access_token';

    public function beforeAction($action)
    {/*{{{*/

        Yii::trace('try to login via access_token');

        $access_token = Yii::$app->getRequest()->get('access_token');

        if (! Yii::$app->getUser()->validateAccessTokenFormat($access_token)) {
            throw new \yii\web\HttpException(
                403,
                'invalid access_token',
                \common\components\ResponseCode::INVALID_ACCESS_TOKEN
            );
        }

        Yii::$app->getUser()->loginByAccessToken($access_token);

        return parent::beforeAction($action);
    }/*}}}*/


}
