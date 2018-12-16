<?php

namespace common\models;

use backend\helpers\NumHelper;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string $stored_id
 * @property string $name
 * @property string $phone
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Store extends \yii\db\ActiveRecord
{

    use KVTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone','address'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'phone','address'], 'string', 'max' => 255],
            ['stored_id', 'setStoreId','skipOnEmpty' => false,'on' => ['create']],
            [['stored_id'], 'unique'],
        ];
    }
    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className(),
        ];
    }/*}}}*/
    public function setStoreId(){

        $this->stored_id = self::generateUniqueStoreId();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] =  ['name', 'phone','address','stored_id'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stored_id' => 'Stored ID',
            'name' => '店名',
            'phone' => '电话',
            'address' => '地址',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function generateUniqueStoreId(){

        return NumHelper::randNum(8);
    }

}
