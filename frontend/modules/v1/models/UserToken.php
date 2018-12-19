<?php

namespace frontend\modules\v1\models;

class UserToken extends \frontend\models\UserToken
{

    use \common\traits\ModelPrepareTrait;
    use \common\traits\SaveExceptionTrait;

    public function fields()
    {
        return [
            'platform', 'open_id', 'access_token', 'expired_at', 'updated_at'
        ];
    }

    public function forceTokenExpired()
    {
        $this->expired_at = time() - 1;

        return $this->save();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

?>