<?php

namespace frontend\modules\v1\components;

use Yii;
use yii\base\Exception;

//use common\models\User;
use frontend\models\User;

class TokenCache extends \yii\base\Object
{
    public $keyString;

    protected $_cache;
    protected $_timeAlive = 600;
    protected $_token;

    public function init()
    {
        if (empty($this->keyString)){

            throw new Exception('key string not set');
        }

        $this->_cache = Yii::$app->redis;
    }

    protected function buildCacheKey($userId)
    {
        return sprintf($this->keyString,
            $userId
        );
    }

    public function setToken($user)
    {
        $token = Yii::$app->security->generateRandomString(32);

        $key = $this->buildCacheKey($user->id);
        $this->_cache->set($key,$token);
        $this->_cache->expire($key,$this->_timeAlive);
//        $this->_cache->set(
//            $this->buildCacheKey($user->id),
//            $token,
//            $this->_timeAlive
//        );

        return $token;
    }

    public function validateToken($user, $token)
    {
        $this->_token = $this->_cache->get($this->buildCacheKey($user->id));

        if (empty($this->_token)) {
            return \common\components\ValidateErrorCode::TOKEN_EXPIRED;
        }
        if (! $this->isMatch($token)) {

            return \common\components\ValidateErrorCode::TOKEN_NOT_MATCH;
        }

        return 0;
    }

    protected function isMatch($token)
    {
        return strcmp($this->_token, $token) === 0;
    }

    public function delToken($user)
    {
        return $this->_cache->del($this->buildCacheKey($user->id));
    }
}

?>