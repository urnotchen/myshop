<?php

namespace frontend\modules\v1\components;

class AccessTokenAuth extends \yii\filters\auth\AuthMethod
{

    public function authenticate($user, $request, $response)
    {
        $accessToken = $this->getAccessToken($request, $user);
        $identity = $user->loginByAccessToken(
            $accessToken
        );

        return $identity;
    }

    protected function getAccessToken($request)
    {
        $accessToken = $request->getAccessToken();

        if (empty($accessToken)) {
            throw new \yii\web\HttpException(
                403,
                'invalid access_token',
                \common\components\ResponseCode::INVALID_ACCESS_TOKEN
            );
        }

        return $accessToken;
    }

}
