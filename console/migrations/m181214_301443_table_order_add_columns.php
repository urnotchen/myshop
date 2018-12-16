<?php

use yii\db\Migration;

class m181214_301443_table_order_add_columns extends Migration{

    public function up(){

        $this->addColumn(\common\models\Order::tableName(),'name',$this->string()->notNull());
        $this->addColumn(\common\models\Order::tableName(),'content',$this->string()->notNull());
        $this->addColumn(\common\models\Order::tableName(),'phone',$this->integer()->unsigned()->notNull());
        $this->addColumn(\common\models\Order::tableName(),'updated_by',$this->integer()->unsigned()->notNull());

    }
}