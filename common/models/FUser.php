<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\FindOrExceptionTrait;
use Yii;

/**
 * This is the model class for table "f_user".
 *
 * @property int $id
 * @property string $user_id
 * @property string $username
 * @property string $password
 * @property int $phone
 * @property string $open_id
 * @property int $is_distributor
 * @property string $total_prize
 * @property int $created_at
 * @property int $updated_at
 */
class FUser extends \yii\db\ActiveRecord
{

    use EnumTrait,FindOrExceptionTrait;

    const DISTRIBUTOR_YES = 1,DISTRIBUTOR_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [[ 'username', 'password', 'phone'], 'required'],
            [['phone', 'is_distributor','sex' ,'created_at', 'updated_at'], 'integer'],
            [['total_prize','prize_now','prize_withdrawal'], 'number'],
            [['password', 'image','open_id','province','city'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 32],
            [['username'], 'unique'],
//            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Phone',
            'open_id' => 'Open ID',
            'is_distributor' => 'Is Distributor',
            'total_prize' => 'Total Prize',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getEnum(){

        return[
            'distributor' => [
                self::DISTRIBUTOR_NO => '普通用户',
                self::DISTRIBUTOR_YES => '分销商'
            ]
        ];
    }
}
