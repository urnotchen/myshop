<?php

namespace frontend\traits;

use frontend\models\UserToken;

trait UserIdentityTrait
{

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

        $token = UserToken::findOneOrException([
            'access_token' => $token,
        ]);

        return $token->user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

}