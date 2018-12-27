<?php

namespace frontend\models;

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
        $model->save();
        var_dump($model->getErrors());
        return $model;
    }
}