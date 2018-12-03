<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_goods".
 *
 * @property int $id
 * @property string $goods_id
 * @property string $stored_id
 * @property int $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class StoreGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'stored_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['goods_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['stored_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'stored_id' => 'Stored ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
