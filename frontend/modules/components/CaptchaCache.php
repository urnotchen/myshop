<?php

namespace frontend\modules\v1\components;

use Yii;

use common\models\User;

class CaptchaCache extends \yii\base\Object
{
    const MAX_TRY_TIMES = 5;

    protected $_cache;
    protected $_timeAlive = 600;
    protected $_captcha = 0, $_remainTimes = 0;

    public function init()
    {
        $this->_cache = Yii::$app->redis;
    }

    protected function buildCaptchaCacheKey($userId)
    {
        return sprintf("sb_%s_rePwdCapt",
            $userId
        );
    }

    public function setCaptcha($user)
    {
        if (empty($user->id)){

            throw new \yii\web\HttpException( 400, 'user not given',
                \common\components\ResponseCode::USER_CAPTCHA_USER_NOT_GIVEN
            );
        }

        $captcha = substr(strval(mt_rand(1000000, 1999999)),-6,6);

        $value = [
            'capt' => $captcha,
            'remTim' => self::MAX_TRY_TIMES,
        ];

        $key = $this->buildCaptchaCacheKey($user->id);
        $this->_cache->set(
            $key,
            serialize($value)
        );
        $this->_cache->expire($key, $this->_timeAlive);

        return $captcha;
    }

    public function checkChance($user, $code)
    {
        if (empty($user->id)){

            throw new \yii\web\HttpException( 400, 'user not given',
                \common\components\ResponseCode::USER_CAPTCHA_USER_NOT_GIVEN
            );
        }

        $key = $this->buildCaptchaCacheKey($user->id);
        $value = unserialize($this->_cache->get($key));
//return $value;
        if (empty($value)) {

            throw new \yii\web\HttpException(
                400, 'user-captcha is expired',
                \common\components\ResponseCode::USER_CAPTCHA_IS_EXPIRED
            );
        }

        $this->_captcha = $value['capt'];
        $this->_remainTimes = $value['remTim'];

        # 验证码输错剩余次数，最多输错5次
        if (! $this->hasRemainTimes()) {
            $this->delCaptcha($user);

            throw new \yii\web\HttpException(
                403, 'user captcha times tried out',
                \common\components\ResponseCode::USER_CAPTCHA_TRIED_OUT
            );
        }

        if (! $this->isMatch($code)) {
            $this->updateRemainTimes($user);

            throw new \yii\web\HttpException(400, 'captcha not match',
                \common\components\ResponseCode::USER_CAPTCHA_NOT_MATCH
            );
        }

        return true;
    }

    protected function hasRemainTimes()
    {

        return $this->_remainTimes > 0;
    }

    protected function isMatch($code)
    {
        return strcmp($this->_captcha, $code) === 0;
    }

    protected function updateRemainTimes(User &$user)
    {
        $key = $this->buildCaptchaCacheKey($user->id);
        $value = [
            'capt' => $this->_captcha,
            'remTim' => $this->_remainTimes-1,
        ];

        $ttl = $this->_cache->ttl($key);
        $this->_cache->set($key, serialize($value));
        $this->_cache->expire($key, $ttl);
    }

    public function delCaptcha(User &$user)
    {

        return $this->_cache->del($this->buildCaptchaCacheKey($user->id));
    }
}

?>