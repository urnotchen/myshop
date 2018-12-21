<?php
namespace backend\models;

class Settings extends \common\models\Settings{

    /*
     * 获取配置信息 todo 用缓存
     * */
    public static function getAllSettings(){

        return self::kv('key','value');
    }
}