<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;



class Qiniu extends \crazyfd\qiniu\Qiniu
{
//    public $expiration;
//
//    public function init()
//    {
//        parent::init();
//
//        if (!isset($this->expiration)) {
//            throw new InvalidConfigException('请先配置使用的Expiration');
//        }
//    }

    public function delete($fileName)
    {

        if (!isset($this->managers['bucket'])) {
            $this->managers['bucket'] = new BucketManager($this->auth);
        }

        $err = $this->managers['bucket']->delete($this->bucket, basename($fileName));

        if (is_null($err)) {
            return [
                'code' => self::CODE_SUCCESS,
                'message' => self::MESSAGE_SUCCESS,
            ];
        } else {
            return [
                'code' => $err->code(),
                'message' => $err->message(),
            ];
        }
    }

    public function generateUploadToken()
    {

        return $this->auth->uploadToken($this->bucket, null,10 * 12 * 30 * 86400);
    }

}