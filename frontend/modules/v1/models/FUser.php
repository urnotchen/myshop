<?php

namespace frontend\modules\v1\models;

use common\components\ResponseCode;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class FUser extends \frontend\models\FUser {


    /*
     * 判断此用户是否为经销商
     * */
    public static function isDistributor($user_id){

        $res =  self::find()->where(['user_id' => $user_id])->one();
        if(!$res){
            return false;
        }else{
            if($res['is_distributor'] == FUser::DISTRIBUTOR_YES){
                return $res;
            }else{
                return False;
            }
        }
    }
    /*
     * 用户支付 分销商奖金提成
     * */
    public static function addDistributorPrize($distributor_id,$prize){

        $model = self::findOneOrException(['id' => $distributor_id]);
        if($model->is_distributor != self::DISTRIBUTOR_YES){
            throw new HttpException(403,'用户分销商有误',ResponseCode::USER_DISTRIBUTOR_FAILED);
        }
        $model->total_prize += $prize;
        $model->prize_now += $prize;
        $model->save();
    }
}