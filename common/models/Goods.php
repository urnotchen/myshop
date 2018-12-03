<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $goods_id
 * @property string $name
 * @property string $content
 * @property string $distributor_prize
 * @property string $sales_initial
 * @property string $sales_actual
 * @property string $email
 * @property int $status
 * @property int $is_delete
 * @property string $sales_begin
 * @property string $sales_end
 * @property string $stock_num
 * @property string $store_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'name', 'content', 'sales_initial', 'sales_actual', 'email', 'sales_begin', 'sales_end', 'stock_num', 'store_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['content'], 'string'],
            [['distributor_prize', 'sales_initial', 'sales_actual'], 'number'],
            [['status', 'is_delete', 'sales_begin', 'sales_end', 'stock_num', 'store_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['goods_id', 'name', 'email'], 'string', 'max' => 255],
            [['goods_id'], 'unique'],
            [['email'], 'unique'],
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
            'name' => 'Name',
            'content' => 'Content',
            'distributor_prize' => 'Distributor Prize',
            'sales_initial' => 'Sales Initial',
            'sales_actual' => 'Sales Actual',
            'email' => 'Email',
            'status' => 'Status',
            'is_delete' => 'Is Delete',
            'sales_begin' => 'Sales Begin',
            'sales_end' => 'Sales End',
            'stock_num' => 'Stock Num',
            'store_id' => 'Store ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
