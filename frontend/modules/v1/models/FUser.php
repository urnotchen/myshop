<?php

namespace frontend\modules\v1\models;

use yii\web\NotFoundHttpException;

class FUser extends \frontend\models\FUser {


    /*
     * 判断此用户是否为经销商
     * */
    public static function isDistributor($user_id){

        $res =  self::find()->where(['user_id' => $user_id])->one();

        if(!$res){
            throw new NotFoundHttpException('not have this user');
        }else{
            if($res['is_distributor'] == FUser::DISTRIBUTOR_YES){
                return True;
            }else{
                return False;
            }
        }
    }
}