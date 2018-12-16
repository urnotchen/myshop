<?php

namespace frontend\components\rest;

class User extends \yii\web\User
{

    /**
     * @param \yii\web\IdentityInterface $identity
     * @param int $duration
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function login(\yii\web\IdentityInterface $identity, $duration = 0)
    {
        if (parent::login($identity, $duration)) {

            return true;
        }

        throw new \yii\web\HttpException(
            403,
            'login failed',
            \common\components\ResponseCode::USER_LOGIN_FAILED
        );
    }

}
