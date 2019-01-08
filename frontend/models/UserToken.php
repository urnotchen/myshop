<?php

namespace frontend\models;
use common\components\ResponseCode;
use common\helpers\NumHelper;
use frontend\models\FUser as User;
use yii\db\Exception;
use yii\web\HttpException;

class UserToken extends \common\models\UserToken
{
    use \common\traits\FindOrExceptionTrait {
        findOneOrException as traitFindOneOrException;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findOneOrException(array $where, $closure = false)
    {
        try {

            $model = static::traitFindOneOrException($where, $closure);
//            $model->checkAlive();

            return $model;

        } catch (\yii\web\HttpException $e) {

            if ($e->statusCode == 404) {
                throw new \yii\web\HttpException(
                    403,
                    'invalid access-token',
                    \common\components\ResponseCode::INVALID_ACCESS_TOKEN
                );
            }

            throw $e;
        }
    }


    public static function updateToken($user_id,$open_id,$access_token,$expired_time,$refresh_token){

        $model = self::findOne(['user_id' => $user_id]);
        if(!$model) {
            $model = new self();
            $model->open_id = $open_id;
            $model->user_id = $user_id;
        }
        $model->scenario = self::SCENARIO_LOGIN_THIRD_PARTY;
        $model->setAttributes([
            'access_token' => $access_token,
            'expired_at' => $expired_time + time(),
            'refresh_token' => $refresh_token,
        ]);
//            var_dump($model);
         if(!$model->save()){
             throw new Exception(500,'数据库错误',ResponseCode::DATABASE_SAVE_FAILED);
         }

    }


}

?>