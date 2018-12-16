<?php

use yii\db\Migration;

class m181206_301442_table_goods_add_column_image extends Migration{

    public function up(){

        $this->addColumn(\common\models\Goods::tableName(),'image_url',$this->string()->notNull());
    }
}