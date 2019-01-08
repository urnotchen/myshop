<?php

namespace frontend\models;

use common\components\ResponseCode;
use yii\db\Exception;
use yii\web\HttpException;

class FUser extends \common\models\FUser  implements \yii\web\IdentityInterface {

    use \frontend\traits\UserIdentityTrait;

    public static function updateUser($open_id,$userinfo = null){

        $model = self::findOne(['open_id' => $open_id]);
        if(!$model){
            $model = new self();
            $model->open_id = $open_id;
        }
        if($userinfo){
            $model->setAttributes([
                'username' => $userinfo['nickname'],
                'image' => $userinfo['headimgurl'],
                'sex' => $userinfo['sex'],
                'city' => $userinfo['city'],
                'province' => $userinfo['province'],
            ]);
        }
        if(!$model->save()){
            throw new Exception(500,'数据库错误',ResponseCode::DATABASE_SAVE_FAILED);
        }
        return $model;
    }
}