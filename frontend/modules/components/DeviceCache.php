<?php

namespace frontend\modules\v1\components;

use Yii;

use common\models\User;
use common\models\UserToken;
use common\models\StatDaily;

class DeviceCache extends \yii\base\Object
{
    protected $_cache;
    protected $_timeAlive = 600;

    public function init()
    {
        $this->_cache = Yii::$app->redis;
    }

    protected function buildDeviceCacheKey($userId)
    {
        return sprintf("sb_%s_devices",
            $userId
        );
    }

    /**
     * @param UserToken $userToken
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function operateLogin(UserToken &$userToken)
    {
        $userTokenIsIphone = $this->isIphone($userToken->device);

        $key = $this->buildDeviceCacheKey($userToken->user_id);
        $user = User::findOneOrException(['id' => $userToken->user_id]);
        $devices = unserialize($this->_cache->get($key));

        //统计不是当天注册的用户
        if ($user->created_at < Yii::$app->dateFormat->getTodayTimestamp()) {

            StatDaily::dailyStat($user->id);
        }

        $userIsSvip = $user->isSvip();
        foreach ((array)$devices as $k => $v) {
            //删除过期设备
            if ($v < time()) {
                unset($devices[$k]);

                continue;
            }

            //高级用户不限制手机登录数量
            if ($userIsSvip) {

                continue;
            }

            //其他用户只允许一台iPhone登录
            if ($userTokenIsIphone) {
                if ($this->isIphone($k) && $k!==$userToken->device) {

                    throw new \yii\web\HttpException(403,
                        'phones over maximum',
                        \common\components\ResponseCode::PHONE_OVER_MAX
                    );
                }
            }

        }

        //空 刷新 小于两台 标准用户小于四台 高级用户，允许连接服务器
        if (
            empty($devices) || array_key_exists($userToken->device, $devices) ||
            count($devices)<2 || ($user->isVip()&&count($devices)<4) || $user->isSvip()
        ) {

            $devices[$userToken->device] = time() + $this->_timeAlive;
            $this->_cache->set($key, serialize($devices));
            $this->_cache->expire($key, $this->_timeAlive);

            return true;
        }

        throw new \yii\web\HttpException(403,
            'pads over maximum',
            \common\components\ResponseCode::PAD_OVER_MAX
        );
    }

    protected function isIphone($device)
    {

        return strpos(reset(explode(UserToken::SEPARATOR, $device)), 'iphone') !== false;
    }

    /**
     * @param UserToken $userToken
     * @return bool
     */
    public function operateLogout(UserToken &$userToken)
    {
        $key = $this->buildDeviceCacheKey($userToken->user_id);
        $devices = unserialize($this->_cache->get($key));

        foreach ((array)$devices as $k => $v) {

            if ($v < time() || $k==$userToken->device) {

                unset($devices[$k]);
            }
        }

        $this->_cache->set($key, serialize($devices));
        $this->_cache->expire($key, $this->_timeAlive);

        return true;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getOnlineDevices(User &$user)
    {
        $key = $this->buildDeviceCacheKey($user->id);
        $devices = (array)unserialize($this->_cache->get($key));

        foreach ($devices as $k => $v) {

            if ($v < time()) {

                unset($devices[$k]);
            }
        }

        $this->_cache->set($key, serialize($devices));
        $this->_cache->expire($key, $this->_timeAlive);

        return array_keys($devices);
    }
}

?>