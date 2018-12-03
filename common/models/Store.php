<?php

namespace common\models;

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
            [['stored_id', 'name', 'phone', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['stored_id', 'name', 'phone'], 'string', 'max' => 255],
            [['stored_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stored_id' => 'Stored ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
