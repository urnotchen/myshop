<?php
namespace common\models;
use common\traits\KVTrait;

/**
 * Class UserToken
 * @package common\models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $platform
 * @property string $open_id
 * @property string $access_token
 * @property integer $expired_at
 * @property string $device
 * @property string $name
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserToken extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;
    use KVTrait;

    const
        SCENARIO_DEFAULT = 'default',
        SCENARIO_LOGIN_EMAIL = 'login_email',
        SCENARIO_LOGIN_THIRD_PARTY = 'login_third_party';

    const PLATFORM_QQ = 1, PLATFORM_SINA = 2, PLATFORM_WECHAT = 3, PLATFORM_EMAIL = 4;

    const SEPARATOR = '~';

    const TYPE_PHONE = 1, TYPE_PAD = 2;

    public static function tableName()
    {
        return 'user_token';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['open_id', 'access_token','registration_id'], 'string'],
            [['user_id', 'platform', 'expired_at'], 'integer'],

            ['open_id', 'required', 'on' => self::SCENARIO_LOGIN_THIRD_PARTY],
            ['access_token', 'default', 'value' => self::generateAccessToken(), 'on' => self::SCENARIO_LOGIN_EMAIL],
            ['platform', 'default', 'value' => self::PLATFORM_EMAIL, 'on' => self::SCENARIO_LOGIN_EMAIL],

            [['user_id', 'platform', 'expired_at', 'access_token'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT  => [],
            self::SCENARIO_LOGIN_EMAIL =>
                ['user_id', 'expired_at','registration_id', 'access_token', 'platform'],
            self::SCENARIO_LOGIN_THIRD_PARTY =>
                ['user_id', 'expired_at','registration_id', 'access_token', 'platform', 'open_id']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => 'User ID',
            'platform'     => 'Platform',
            'open_id'      => 'Open ID',
            'access_token' => 'Access Token',
            'expired_at'   => 'Expire At',
            'device'       => 'Device',
            'type'         => 'TYPE',
            'created_at'   => 'Created At',
        ];
    }

    public static function getEnumData()
    {
        return [
            'platform' => [
                self::PLATFORM_QQ   => 'QQ',
                self::PLATFORM_SINA => '微博',
                self::PLATFORM_WECHAT => '微信',
                self::PLATFORM_EMAIL => '邮箱'
            ],
        ];
    }

    /**
     * @return string
     */
    public static function generateAccessToken()
    {
        do {
            $token = \Yii::$app->security->generateRandomString(32);
        } while (static::find()->where(['access_token' => $token])->exists());

        return $token;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired_at < time();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return bool
     */
    public function isIphone()
    {
        return $this->type == self::TYPE_PHONE;
    }

    public static function tokenExpired($token){

         return self::updateAll(['expired_at' => time() - 1], [
            'access_token' => $token
        ]);

    }
}


?>