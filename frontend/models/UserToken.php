<?php

namespace frontend\models;
use frontend\models\FUser as User;

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
            $model->checkAlive();

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

    public function checkAlive()
    {
        if ($this->isExpired()) {

            throw new \yii\web\HttpException(403,
                'access_token has been expired',
                \common\components\ResponseCode::ACCESS_TOKEN_EXPIRED
            );
        }

        return true;
    }
}

?>